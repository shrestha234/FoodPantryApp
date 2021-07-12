package data;

import logic.TemplateLogic;

import java.sql.*;
import java.util.ArrayList;

/** Programmer Name: Bhupesh Shrestha
 *  Data Layer Class
 *  Date 06/06/2020
 */

public class TemplateDatabase {
    private static String INSERT_QUERY = "INSERT into Template(UserID, Message, Name, Subject) values(26,?,?,?)";
    private static String DISPLAY_QUERY = "SELECT Name, Subject, Message FROM Template";

    /**
     * Method to insert user's subject field and message field input from GUI to the Database
     */

    public static void insertTemplate(String name, String subject, String message) {
        Connection connection = ConnectDb.connect();

        //creating object of Template class
        TemplateLogic temp = new TemplateLogic(name,subject,message);

        try {
            PreparedStatement stmt = connection.prepareStatement(INSERT_QUERY);

            stmt.setString(3, temp.getName());
            stmt.setString(1, temp.getSubject());
            stmt.setString(2, temp.getMessage());

            stmt.executeUpdate();
        }
        catch (SQLException e) {
            e.printStackTrace();
        }
    }


    public static ArrayList<TemplateLogic> getAllFields() {
        Connection connection = ConnectDb.connect();

        ArrayList<TemplateLogic> templates = new ArrayList<>();

        try {
            PreparedStatement stmt = connection.prepareStatement(DISPLAY_QUERY);
            ResultSet rs = stmt.executeQuery();
            templates.add(new TemplateLogic("SELECT TEMPLATE:","",""));
            while (rs.next()) {
                templates.add(new TemplateLogic(rs.getString("Name"),
                        rs.getString("Subject"),
                        rs.getString("Message")));
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return templates;
    }

}
