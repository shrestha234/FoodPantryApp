package logic;

import data.NotifyDatabase;

import java.util.ArrayList;

/**
 * Receive information from NotifyUI and send it along to NotifyData
 * @author Brandon Rankin
 */
public class NotifyLogic {
    private NotifyDatabase notifyDatabase = new NotifyDatabase();
    private ArrayList<String> campusLogic;
    private String subjectLogic;
    private String messageLogic;
    private int senderUserID;
    private int notifyRecipientTotal;
    private int templateID;

    /**
     * This method sets the inputs from the UI into variables for this class.
     */
    public NotifyLogic(){
        campusLogic = new ArrayList<>();
        subjectLogic = "";
        messageLogic = "";
        senderUserID = 0;
        templateID = 0;
    }

    public void setCampus(ArrayList campuses){campusLogic = campuses;}
    public void setSubject(String subject){subjectLogic = subject;}
    public void setMessage(String message){messageLogic = message;}
    public void setUserID(int userID){senderUserID = userID;}
    public void setTemplateID(int tempID){templateID = tempID;}

    /**
     * For each campus selection, the notification is processed separately through both
     * the notifyDatabase.sendNotification method and the notifyDatabase.logNotification method.
     * It also adds the total number of notifications sent to each campus to a running total.
     * @return total number of notification recipients according to the data layer
     */
    public int processNotifications(){
        String campusVar;

        for (String campus : campusLogic) {
            campusVar = campus;
            int notifyRecipientAddition = notifyDatabase.sendNotification(campusVar, subjectLogic, messageLogic, senderUserID, templateID);
            notifyRecipientTotal = notifyRecipientTotal + notifyRecipientAddition;
            notifyDatabase.logNotification(campusVar);
        }
        return notifyRecipientTotal;
    }

    public ArrayList<String> getCampus(){return campusLogic;}
    public String getSubject(){return subjectLogic;}
    public String getMessage(){return messageLogic;}
    public int getTemplateID(){return templateID;}

    /**
     * Read all templates from the database and return them as a list of TemplateLogic objects
     * @return a list of templates from the database
     */
    public ArrayList<TemplateLogic> readTemplates() {
        ArrayList<TemplateLogic> templates = NotifyDatabase.readTemplateData();
        return templates;
    }

    /**
     * Read all users from the database and return them as a list of UserObj objects
     * @return a list of users from the database
     */
    public ArrayList<UserObj> readUsers() {
        ArrayList<UserObj> users = NotifyDatabase.readUserData();
        return users;
    }
}
