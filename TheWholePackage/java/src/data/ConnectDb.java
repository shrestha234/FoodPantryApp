package data;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;

import static java.lang.System.exit;

/**
 * Author: Kelly Nair
 * Date: 6/6/2020
 * Connection class to connect to SQL Database
 */

public class ConnectDb {

    static Connection connection = null;
    private static String DATABASE_URL = "jdbc:jtds:sqlserver://cisdbss.pcc.edu/234a_TheWholePackage";
    private static String USERNAME = "234a_TheWholePackage";
    private static String PASSWORD = "Spring_2020_#})_TheWholePackage";

    /**
     * establish database connection
     */
    public static Connection connect() {
        if (connection != null) {
            return connection;
        } else {
            try{
                connection = DriverManager.getConnection(DATABASE_URL, USERNAME, PASSWORD);
            } catch (SQLException e) {
                e.printStackTrace();
                exit(-1);
            }
        }
        return connection;
    }
}
