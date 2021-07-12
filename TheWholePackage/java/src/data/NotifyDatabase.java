package data;

import logic.TemplateLogic;
import logic.UserObj;

import java.sql.*;
import java.util.ArrayList;

/**
 * Receive information from NotifyLogic
 * Send that information to the database
 * then send that information to all subscribers
 * @author Brandon Rankin
 */
public class NotifyDatabase {
    /** Setup for NotificationLog */
    private Timestamp notifyTime;
    private int notifySenderID;
    private String notifySubject;
    private String notifyMessage;
    private int notifyTemplateID;
    private int notifyRecipientTotal;

    public static ArrayList<TemplateLogic> readTemplateData() {
        String TEMPNAME_SQL = "SELECT Name, Subject, Message, TemplateID FROM Template";
        ArrayList<TemplateLogic> templates = new ArrayList<>();
        Connection connection = ConnectDb.connect();
        try (
                PreparedStatement stmt = connection.prepareStatement(TEMPNAME_SQL)
        ) {
            try (ResultSet rs = stmt.executeQuery()) {
                templates.add(new TemplateLogic("[None]","", "", 0));
                while (rs.next()) {
                    templates.add(new TemplateLogic(
                            rs.getString("Name"),
                            rs.getString("Subject"),
                            rs.getString("Message"),
                            rs.getInt("TemplateID")));

                }
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return templates;
    }

    public static ArrayList<UserObj> readUserData() {
        String USERNAME_SQL = "SELECT UserID, FirstName, LastName, Role FROM Users WHERE Role = 'Staff' OR Role = 'Manager' ORDER BY LastName, FirstName";
        ArrayList<UserObj> users = new ArrayList<>();
        Connection connection = ConnectDb.connect();
        try (
                PreparedStatement stmt = connection.prepareStatement(USERNAME_SQL)
        ) {
            try (ResultSet rs = stmt.executeQuery()) {
                users.add(new UserObj(0, "Please", "Select a Sender", ""));
                while (rs.next()) {
                    users.add(new UserObj(
                            rs.getInt("UserID"),
                            rs.getString("FirstName"),
                            rs.getString("LastName"),
                            rs.getString("Role")));
                }
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return users;
    }

    /** Send the notification to each user email in the database */
    public int sendNotification(String sendCampus, String subject, String message, int senderUserID, int templateID) {
        notifyTime = new Timestamp(System.currentTimeMillis());
        notifySenderID = senderUserID;
        notifySubject = subject;
        notifyMessage = message;
        notifyTemplateID = templateID;
        notifyRecipientTotal = 0;

        String EMAIL_SQL = "SELECT Email FROM Users WHERE Campus = '" + sendCampus + "' AND Receive = 'Yes'";
        StringBuilder toEmails = new StringBuilder(); //builds a string for the to section of the emails.
        Connection connection = ConnectDb.connect();
        try (
                PreparedStatement stmt = connection.prepareStatement(EMAIL_SQL)
        ) {
            try (ResultSet rs = stmt.executeQuery()) {
                while (rs.next()) {
                    toEmails.append(rs.getString("Email"));
                    toEmails.append(", ");
                    notifyRecipientTotal = (notifyRecipientTotal + 1);
                }
                NotifyEmail notifyEmail = new NotifyEmail();
                notifyEmail.sendEmails(toEmails.toString(), notifySubject, notifyMessage);
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return notifyRecipientTotal;
    }

    /** Log the notification in the Notification database */
    public void logNotification(String logCampus) {
        String NOTIFY_SQL = "INSERT INTO NotificationLog (UserID, TemplateID, TimeSent, Message, Campus, RecipientTotal, Subject) " +
                "VALUES (?, ?, ?, ?, ?, ?, ?)";
        Connection connection = ConnectDb.connect();
        try (
                PreparedStatement stmt = connection.prepareStatement(NOTIFY_SQL)
        )
        {
            //Set the record details to insert
            stmt.setInt(1, notifySenderID); //UserID
            stmt.setInt(2, notifyTemplateID); //TemplateID
            stmt.setTimestamp(3, notifyTime); //Timestamp
            stmt.setString(4, notifyMessage); //Message
            stmt.setString(5, logCampus); //Campus
            stmt.setInt(6, notifyRecipientTotal); //Recipients
            stmt.setString(7, notifySubject); //Subject
            stmt.executeUpdate();

        } catch (SQLException e) {
            System.out.println("An exception occurred.Exception is :: " + e);
        }
    }
}
