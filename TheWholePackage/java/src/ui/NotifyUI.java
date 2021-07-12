package ui;

import logic.TemplateLogic;
import logic.NotifyLogic;
import logic.UserObj;
import main.NotifyMain;

import javax.swing.*;
import java.awt.*;
import java.awt.event.ItemEvent;
import java.awt.event.ItemListener;
import java.util.ArrayList;

/**
 * Launch the Notify GUI and send information to NotifyLogic
 * @author Brandon Rankin
 */
public class NotifyUI {
    private JPanel rootPanel;
    private JTextField subjectField;
    private JTextArea messageField;
    private JButton sendNotificationButton;
    private JCheckBox checkSoutheast;
    private JCheckBox checkRockCreek;
    private JCheckBox checkSylvania;
    private JCheckBox checkCascade;
    private JButton closeButton;
    private JComboBox<TemplateLogic> templateComboBox;
    private JComboBox<UserObj> userComboBox;
    private int senderUserID;
    private int templateID;
    NotifyLogic notifyLogic = new NotifyLogic();

    /** Create a NotifyUI object and manage inputs and create a confirmation pop-up */
    public NotifyUI() {
        rootPanel.setPreferredSize(new Dimension(500, 500));

        setUserCombo(); //Set-up User Combo Box
        //ItemChangeListener for detecting state change of users combo box
        class UserItemChangeListener implements ItemListener {
            @Override
            public void itemStateChanged(ItemEvent event) {
                if (event.getStateChange() == ItemEvent.SELECTED) {
                    UserObj item = (UserObj) event.getItem();
                    senderUserID = item.getUserID();
                }
            }
        }
        userComboBox.addItemListener(new UserItemChangeListener());

        setTemplateCombo(); //Set-up Template Combo Box
        //ItemChangeListener for detecting state change of templates combo box
        class TemplateItemChangeListener implements ItemListener {
            @Override
            public void itemStateChanged(ItemEvent event) {
                if (event.getStateChange() == ItemEvent.SELECTED) {
                    TemplateLogic item = (TemplateLogic) event.getItem();
                    subjectField.setText(item.getSubject());
                    messageField.setText(item.getMessage());
                    templateID = item.getTemplateID();
                }
            }
        }
        templateComboBox.addItemListener(new TemplateItemChangeListener());

        // Listens for the "send notification" button click
        sendNotificationButton.addActionListener(actionEvent -> {
            ArrayList<String> notifyCampus = campusSelection();
            notifyLogic.setCampus(notifyCampus);
            String notifySubject = subjectField.getText();
            notifyLogic.setSubject(notifySubject);
            String notifyMessage = messageField.getText();
            notifyLogic.setMessage(notifyMessage);
            notifyLogic.setUserID(senderUserID);
            notifyLogic.setTemplateID(templateID);

            if (notifySubject.isEmpty()){ // Tests if the subject field is empty
                JOptionPane.showMessageDialog(rootPanel, "Subject cannot be blank.");
            }
            else if (notifyMessage.isEmpty()){ // Tests if the message field is empty
                JOptionPane.showMessageDialog(rootPanel, "Message cannot be blank.");
            }
            else if (notifyCampus.isEmpty()){ // Tests if the campus boxes are empty
                JOptionPane.showMessageDialog(rootPanel, "At least one Campus must be selected.");
            }
            else if (senderUserID == 0){ // Tests if the user selection is empty
                JOptionPane.showMessageDialog(rootPanel, "Must select a User as notification sender.");
            }
            // displays the confirmation pop-up, runs the program, and displays the finish message
            else {
                int result = JOptionPane.showConfirmDialog(rootPanel,"Are you sure you want to send notifications?", "Confirmation",
                        JOptionPane.YES_NO_OPTION,
                        JOptionPane.QUESTION_MESSAGE);
                if(result == JOptionPane.YES_OPTION){
                    int notifyRecipientTotal = notifyLogic.processNotifications();
                    if (notifyRecipientTotal == 0){
                        JOptionPane.showMessageDialog(rootPanel, "There was an error. No notifications were sent.");
                    }
                    else {
                        JOptionPane.showMessageDialog(rootPanel, notifyRecipientTotal + " notifications sent successfully.");
                        NotifyMain.closeFrame(); //close the send notification frame.
                    }
                }
            }
        });
        closeButton.addActionListener(e -> NotifyMain.closeFrame()); //Close button closes the frame.
    }

    /**
     * Determines the campus inputs of the user and exports them an array list of strings
     * @return an array list of the campuses
     */
    private ArrayList<String> campusSelection() {
        ArrayList<String> campuses = new ArrayList<>();
        if (checkCascade.isSelected()){
            campuses.add(checkCascade.getText());
        }
        if (checkRockCreek.isSelected()){
            campuses.add(checkRockCreek.getText());
        }
        if (checkSoutheast.isSelected()){
            campuses.add(checkSoutheast.getText());
        }
        if (checkSylvania.isSelected()){
            campuses.add(checkSylvania.getText());
        }
        return campuses;
    }

    /** Send the notification to each user email in the database */
    public void setTemplateCombo() {
        ArrayList<TemplateLogic> templates = notifyLogic.readTemplates();
        for (TemplateLogic temp : templates) {
            templateComboBox.addItem(temp);
        }
    }

    /** Send the notification to each user email in the database */
    public void setUserCombo() {
        ArrayList<UserObj> users = notifyLogic.readUsers();
        for (UserObj userobjs : users) {
            userComboBox.addItem(userobjs);
        }
    }


    /** @return rootPanel for main */
    public JPanel getRootPanel() {
        return rootPanel;
    }
}