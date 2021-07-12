package logic;

import data.LogDatabase;

import java.util.ArrayList;

/**
 * Author: Kelly Nair
 * Date: 5/5/2020
 * Data that will be in the notification log
 * Based on input values, call data base, return the array list of outputs
 * Date: 5/27/2020
 * Added template column to table
 * Added search by employee name
 * Date: 6/3/2020
 * Added full name instead of first name and last name separately
 * Changed field names to begin with lowercase letter
 * Changed class name from MessageLog to LogMessage
 * Date: 6/6/2020
 * Changed the fields to begin with lower case
 */

public class LogMessage {
    private String fullName;
    private String subject;
    private String message;
    private String template;
    private String timeSent;
    private String campus;
    private int recipientTotal;

    /**
     * return the log values
     */
    public LogMessage(String nm, String s, String m, String t, String ts, String c, int rt) {
        fullName = nm;
        subject = s;
        message = m;
        template = t;
        timeSent = ts;
        campus = c;
        recipientTotal = rt;
    }

    /**
     * call the database class and get the array list of values
     */
    public static ArrayList<LogMessage> findLogs(String campusNm, String startDt, String endDt, String empNmsrch) {
        return LogDatabase.findLogs(campusNm, startDt, endDt, empNmsrch);
    }

    /**
     * get methods for each of the values to be returned
     */
    public String getFullName() {
        return fullName;
    }
    public String getSubject() {
        return subject;
    }
    public String getMessage() {
        return message;
    }
    public String getTemplate() {
        return template;
    }
    public String getTimeSent() {
        return timeSent;
    }
    public String getCampus() {
        return campus;
    }
    public int getRecipientTotal() {
        return recipientTotal;
    }
}
