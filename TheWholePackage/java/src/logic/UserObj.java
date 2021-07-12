package logic;

/**
 * A template in the database
 * @author Brandon Rankin
 */
public class UserObj {
    private int userID;
    private String firstName;
    private String lastName;
    private String userRole;

    public UserObj(int userID, String firstName, String lastName, String role) {
        this.userID = userID;
        this.firstName = firstName;
        this.lastName = lastName;
        this.userRole = role;
    }

    public int getUserID() {
        return userID;
    }
    public String getFirstName() {
        return firstName;
    }
    public String getLastName() {
        return lastName;
    }
    public String getRole() {
        return userRole;
    }

    public String toString(){
        return this.lastName + ", " + this.firstName;
    }
}