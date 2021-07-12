package ui;

import com.toedter.calendar.JDateChooser;
import main.LogMain;
import logic.LogMessage;

import javax.swing.*;
import java.awt.*;
import javax.swing.event.DocumentEvent;
import javax.swing.event.DocumentListener;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import javax.swing.table.DefaultTableCellRenderer;
import javax.swing.table.DefaultTableModel;
import javax.swing.table.TableColumnModel;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.regex.Matcher;
import java.util.regex.Pattern;


/** Author Kelly Nair
 * Date: 5/5/2020
 * UI class that get the input values and displays the output into the form
 * Date: 5/16/2020
 * Updated Class Name, startDt/endDt name capitalization
 * Updated table editabiltiy to false
 * Removed hardcoded dates
 * Updated dates for end date as today and start date 30 days prior
 * Updated error message to center in app
 * Removed extra validation for dates
 * Removed createStartDate/createEndDate methods
 * Date: 5/24/2020
 * Added a Campus Combo box to select specific/all campus
 * Put date entry below wording for dates
 * Moved "show logs" button up by dates
 * Made JTable background all one color so gray doesn't show in background when there are just a few logs
 * Combined FirstName/LastName to Employee, made column wider
 * Changed font for date input text boxes to match font and size of rest of GUI
 * Date: 5/27/2020
 * Added template column
 * Added search by employee name
 * Added close button
 * Date: 6/3/2020
 * Added JDatechooser for start and end dates
 * Handled retrieving the logs as soon as there is any change in dates
 * Added sorting to table's rows into asc/desc order
 * Added message popup if there are no logs to display
 * Added Reset button to reset the values to default
 * Date: 6/6/2020
 * Included key listener for employee search
 * Removed "show logs" button
 * Fixed comments to align with standards
 * Changed JCombobox to include data type
 * Changed if/else logic to not have empty ifs
 * Created constants for "calendar" and "date" instead of hard coding
 * Removed the unused getters and fields
 * Changed datechooser to move duplicate code to single method
 * Defined local variables for parameters of getCampusName and getEmpText
 * Included displaying highlighted error for invalid input
 */

public class NotificationLogUI {
    public JPanel rootPanel;
    private JScrollPane scrollPane;
    private JPanel startCal;
    private JPanel endCal;
    private JTextField empText;
    private JComboBox<String> campusCombo;
    private JButton closeButton;
    private JButton resetButton;
    private JTable logTable;
    public JDateChooser startDatechooser;
    public JDateChooser endDatechooser;

    public String startDt;
    public String endDt;
    public String campusName;
    public String empNameSearch;
    public String dtFormat = "yyyy-MM-dd";
    public String campusNames[]={"All", "Cascade", "Sylvania", "Southeast", "Rock Creek"};
    public String uiColumns[]={"Employee", "Subject", "Message", "Template", "Date", "Campus", "Recipient Total"};
    private static Pattern empNamePtrn = Pattern.compile("^[a-zA-Z ]+$");
    public String calPropertyName = "calendar";
    public String dtPropertyName = "date";
    public String isInputValuesValid = "yes";

    /**
     * Call the methods to initialize
     */
    public NotificationLogUI() {
        createScrollPane();
        dateChooser();
        createCampusCombo();
        filterEmpName();
        createTable();
        resetValuesButton();
        windowCloseButton();
        showLogs();
    }

    /**
     * method to initialize the scroll pane and set background color
     */
    private void createScrollPane() {
        scrollPane.getViewport().setBackground(Color.decode("#EDF9FF"));
    }

    /**
     * method to initialize the start and end dates to default values of calendar
     * perform actions to get the values based on property change event of date or calendar
     */
    private void dateChooser() {
        /* Set the start dates */
        startDatechooser = new JDateChooser(getStartCalendar().getTime(),dtFormat);  // set the start date to the subtracted date
        startCal.add(startDatechooser);                                     //set the value back to the ui

        /* Set the start date chooser as not editable and check event to get values */
        startDatechooser.addPropertyChangeListener(new java.beans.PropertyChangeListener() {
            public void propertyChange(java.beans.PropertyChangeEvent evt1) {
                ((JTextField) startDatechooser.getDateEditor().getUiComponent()).setEditable(false);

                /* initialize the changed date string and get the start date into string */
                String startDtChg = getStartDt();
                /*For property change event of date or calendar and start date is changed, call the method to get values */
                if ((calPropertyName.equals(evt1.getPropertyName()) || dtPropertyName.equals(evt1.getPropertyName()))
                        && (startDtChg.equals(startDt) != true)) {
                    /* call show logs method */
                    showLogs();
                }

            }
        });
        startDatechooser.getCalendarButton().setEnabled(true);      //keep the calendar button enabled
        startDt  = getStartDt();                                    //get the start date into string

        /* Set the end dates */
        endDatechooser = new JDateChooser(getEndCalendar().getTime(), dtFormat);        // set the end date to the current date
        endCal.add(endDatechooser);                                         //set the value back to the ui

        /* Set the end date chooser as not editable and check event to get values */
        endDatechooser.addPropertyChangeListener(new java.beans.PropertyChangeListener() {
            public void propertyChange(java.beans.PropertyChangeEvent evt2) {
                ((JTextField) endDatechooser.getDateEditor().getUiComponent()).setEditable(false);

                /* initialize the changed date string and get the end date into string */
                String endDtChg = getEndDt();

                /*For property change event of date or calendar and end date is changed, call the method to get values */
                if ((calPropertyName.equals(evt2.getPropertyName()) || dtPropertyName.equals(evt2.getPropertyName()))
                && (endDtChg.equals(endDt) != true)) {
                    /* call show logs method */
                    showLogs();
                    }
                }
        });
        endDatechooser.getCalendarButton().setEnabled(true);        //keep the calendar button enabled
        endDt  = getEndDt();                                        //get the end date into string
    }

    /**
     * method to get the start calendar
     */
    public Calendar getStartCalendar() {
        Calendar startCalendarValue = Calendar.getInstance();                             //current date
        startCalendarValue.add(Calendar.DATE,-30);                                // subtract 30 days from today
        return startCalendarValue;
    }

    /**
     * method to get the end calendar
     */
    public Calendar getEndCalendar() {
        Calendar endCalendarValue = Calendar.getInstance();                             //current date
        return endCalendarValue;
    }

    /**
     * method to get the start date
     */
    public String getStartDt() {
        String startDt = ((JTextField) startDatechooser.getDateEditor().getUiComponent()).getText();   //set the string to the date chooser date
        return startDt;
    }

    /**
     * method to get the end date
     */
    public String getEndDt() {
        String endDt = ((JTextField) endDatechooser.getDateEditor().getUiComponent()).getText();   //set the string to the date chooser date
        return endDt;
    }

    /**
     * method to initialize the action listener for combo box from UI.
     * perform actions to limit the display to selected campus
     */
    private void createCampusCombo() {
        /* listener for campus combo box */
        campusCombo.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent ec) {
                showLogs();
            }
        });
        /* include the list to be displayed */
        campusCombo.setModel(new DefaultComboBoxModel (campusNames));
    }

    /**
     * method to perform actions to limit the display to input employee name
     */
    private void filterEmpName() {
        /* listener for employee name text */
        empText.getDocument().addDocumentListener(new DocumentListener() {
            /* For any change, call the show log method to get the values */
            public void changedUpdate(DocumentEvent eec) { showLogs(); }
            public void removeUpdate(DocumentEvent eer)  { showLogs(); }
            public void insertUpdate(DocumentEvent eei)  { showLogs(); }
        });
    }

    /**
     * method to initialize the table for output
     **/
    private void createTable() {
        Object[][] data = {uiColumns};
        logTable.setModel(new DefaultTableModel(
                data, uiColumns
        ));

        TableColumnModel columns = logTable.getColumnModel();
        columns.getColumn(0).setMinWidth(100); //setting the column to be wider//
        columns.getColumn(2).setMinWidth(250); //setting the column to be wider//

        /* make the relevant columns centered */
        DefaultTableCellRenderer centerRender = new DefaultTableCellRenderer();
        centerRender.setHorizontalAlignment(JLabel.CENTER);
        columns.getColumn(0).setCellRenderer(centerRender);
        columns.getColumn(3).setCellRenderer(centerRender);
        columns.getColumn(5).setCellRenderer(centerRender);
        columns.getColumn(6).setCellRenderer(centerRender);
    }

    /**
     * method to restart a search using reset button
     */
    private void resetValuesButton() {
        resetButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent er) {
                /* call the method to initialize the input values */
                initializeUI();

                /* call the show logs method to populate the UI based on this initialized values */
                showLogs();
            }
        });
    }

    /**
     * method to close the GUI using close button
     */
    private void windowCloseButton() {
        closeButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent ew) {
                LogMain.closeFrame();
            }
        });
    };

    /**
     * This method initializes the log retrieval from message log array list
     * Validates each of the input dates, if there is no input, get the default values
     * Retrieves the array of log records from database call and returns to UI
     */
    private void showLogs() {
        /* Re-initialize the flag that checks validity of input values and re-initialize the foreground color */
        isInputValuesValid = "yes";
        empText.setForeground(UIManager.getColor("TextField.foreground"));

        /* Get the values prior to getting logs */
        startDt  = getStartDt();            //get the start date into string
        endDt  = getEndDt();                //get the end date into string
        campusName = getCampusName();         //validate the input campus name selected
        empNameSearch = getEmpText();       //validate empname search string

        /* prepare the default table model */
        DefaultTableModel model = (DefaultTableModel) logTable.getModel();
        logTable.setEnabled(false);     //to make sure that the data displayed in table is Not editable
        logTable.setAutoCreateRowSorter (true); //use swing table component to sort table's rows into asc/desc order
        model.setRowCount(0);           //to clear out existing data

        /* Input values are valid, fetch values from database and populate the table*/
        if (isInputValuesValid.equalsIgnoreCase("yes"))
        {
            /* call the method, pass input values and get the array of output records */
            ArrayList<LogMessage> msglogs = LogMessage.findLogs(campusName, startDt, endDt,empNameSearch);

            /* add rows of output to the UI table based on what is retrieved from the database call */
            for (LogMessage msglog : msglogs) {
                model.addRow(new Object[]{
                        msglog.getFullName(),
                        msglog.getSubject(),
                        msglog.getMessage(),
                        msglog.getTemplate(),
                        msglog.getTimeSent(),
                        msglog.getCampus(),
                        msglog.getRecipientTotal()
                });
            }
            /* check on how many records are retrieved. If no records and no prior errors in validations, show the meesage */
            if((model.getRowCount() == 0) && (isInputValuesValid.equalsIgnoreCase("yes"))) {
                JOptionPane.showMessageDialog(rootPanel, "No Message logs for the search criteria");
            }
        }else {
            /* When the input value is invalid, highlight in red and do not fetch values from database*/
            empText.setForeground(Color.red);   //set the color to red
            empText.requestFocusInWindow();     //keep the focus on this error
        }
    }

    /**
     * method to validate the campus selection.
     * if input is all, pass spaces, else pass the value
     */
    public String getCampusName() {
        String campusNameToValidate = campusCombo.getSelectedItem().toString();

        /* the input campus name is All, set it to spaces */
        if (campusNameToValidate.equals("All")) {
            campusNameToValidate = "";           //empty string fetches everything from the % in the query
        }
        return campusNameToValidate;
    }

    /**
     * method to validate the employee name string.
     * call the method to validate the regex pattern format, if error, show an error message dialog
     */
    public String getEmpText() {
        String empNameSearchToValidate = this.empText.getText();

        /* the input is null or empty, do nothing. else validate the string */
        if (empNameSearchToValidate != null && !empNameSearchToValidate.isEmpty()) {
            /* call the method to validate that the string in the expected format */
            if (!isThisValidEmpName(empNameSearchToValidate)) {
                isInputValuesValid = "no";
                JOptionPane.showMessageDialog(rootPanel, "Input for employee name is invalid. Enter alphabetical values");
            }
        }else {
            empNameSearchToValidate = "";           //empty string fetches everything from the % in the query
        }
        return empNameSearchToValidate;
    }

    /**
     * method to validate the input string. return boolean if the format is not correct
     */
    public static boolean isThisValidEmpName(String empName){
            Matcher mtch = empNamePtrn.matcher(empName); //check emp name against the regex pattern
            if(mtch.matches()){
                return true;
            }
            return false;
    }

    /**
     * initialize the UI input values
     */
    private void initializeUI() {
        empText.setText("");                                            // initialize input employee text to default
        startDatechooser.setCalendar(getStartCalendar());               // set the start date to the initialized calendar date
        endDatechooser.setCalendar(getEndCalendar());                   // set the end date to the initialized calendar date
        campusCombo.setModel(new DefaultComboBoxModel (campusNames));   // initialize campus combo box to default
    };

}
