package data;

import logic.LogMessage;

import java.sql.*;
import java.util.ArrayList;

import static java.lang.System.exit;

/**
 * Author: Kelly Nair
 * Date: 5/5/2020
 * Based on inputs, read the database, return output values in array format
 * Date: 5/16/2020
 * Updated query from JOIN to RIGHT JOIN
 * Updated query to have end date plus 23:59:59 to show whole day so start/end dates are inclusive
 * Removed extra query
 * Date: 5/24/2020
 * Changed query to include campus
 * Changed FirstName/LastName to FullName to display as Employee in table
 * Date 5/27/2020
 * Changed query to pull template name
 * Date 6/03/2020
 * Included concatenation and handle nulls for name handling
 * Date 6/06/2020
 * included call to the new class to establish database connection
 */

/**
 * connect to the database and retrieve records based on query
 */
public class LogDatabase {

    /**
     * specific query to grab columns of data between specific dates
     */
    private static final String FIND_DATE_SQL = "SELECT CONCAT(Users.FirstName, ' ', Users.LastName) AS FullName, " +
            "SUBSTRING(NotificationLog.Subject, 1, 50) AS Subject, SUBSTRING(NotificationLog.Message, 1, 50) AS Message, " +
            "SUBSTRING(Template.Name, 1, 50) AS Template, FORMAT(NotificationLog.TimeSent, 'yyyy-MM-dd') AS TimeSent, " +
            "NotificationLog.Campus, NotificationLog.RecipientTotal \n" +
            "FROM Users RIGHT JOIN NotificationLog ON Users.UserID = NotificationLog.UserID \n" +
            "LEFT JOIN Template ON NotificationLog.TemplateID = Template.TemplateID \n" +
            "WHERE NotificationLog.TimeSent BETWEEN ? \n" +
            "AND ? + '23:59:59' \n" +
            "AND NotificationLog.Campus LIKE '%' + ? + '%' \n" +
            "AND CONCAT(lower(Users.FirstName),  ' ' , lower(Users.LastName)) LIKE '%' + lower(?) + '%' \n" +
            "ORDER BY NotificationLog.TimeSent DESC";

    /**
     * setting up table to get dates and columns in GUI
     */
    public static ArrayList<LogMessage> findLogs(String campusNm, String startDt, String endDt, String empNmsrch) {
        /* establish database connection */
        Connection connection = ConnectDb.connect();
        ArrayList<LogMessage> msglogs = new ArrayList<LogMessage>();
        try {
            PreparedStatement pstmt = connection.prepareStatement(FIND_DATE_SQL); //prepare statement
            pstmt.setDate(1, Date.valueOf(startDt));                //first parameter for the SQL
            pstmt.setDate(2, Date.valueOf(endDt));                  //second parameter for the SQL
            pstmt.setString(3, campusNm);                           //third parameter for the SQL
            pstmt.setString(4, empNmsrch);                          //fourth parameter for the SQL
            ResultSet rs = pstmt.executeQuery();                                  //execute query and get results
            while (rs.next()) {
                msglogs.add(new LogMessage(
                                rs.getString("FullName"),
                                rs.getString("Subject"),
                                rs.getString("Message"),
                                rs.getString("Template"),
                                rs.getString("TimeSent"),
                                rs.getString("Campus"),
                                rs.getInt("RecipientTotal")
                        )
                );
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return msglogs;
    }
}