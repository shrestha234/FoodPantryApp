package ui;

import logic.TemplateLogic;
import main.NotifyMain;
import main.TemplateMain;


import javax.swing.*;
import java.awt.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.awt.event.ItemEvent;
import java.awt.event.ItemListener;
import java.util.ArrayList;


/** Programmer Name: Bhupesh Shrestha
 *  TemplateForm class for TemplateForm GUI
 *  Date 05/27/2020
 */

public class TemplateForm {
    private JTextField subjectField;
    private JTextArea messageField;
    private JButton closeButton;
    private JButton saveTemplateButton;
    private JPanel rootPanel;
    private JTextField nameField;
    private JComboBox<TemplateLogic> nameComboBox;
    private JLabel templateName;

    private JLabel checkSubject;
    private JLabel checkMessage;


    /**
     * Setting the size of the TemplateForm GUI
     */
    public TemplateForm() {


        rootPanel.setPreferredSize(new Dimension(700, 455));
        createNameCombo();

        /**
         * ActionListener added for "Save Template" button
         */
        saveTemplateButton.addActionListener(new ActionListener() {

            @Override
            public void actionPerformed(ActionEvent e) {

                // Input validation to check the empty Name Field, Subject Field and Message Field

                if (subjectField.getText().isEmpty() && messageField.getText().isEmpty() && nameField.getText().isEmpty()) {
                    JOptionPane.showMessageDialog(rootPanel, "Template form is empty.");
                }
                else if (nameField.getText().isEmpty()){
                    JOptionPane.showMessageDialog(rootPanel, "Template name is empty");
                }
                else if (subjectField.getText().isEmpty()) {
                    JOptionPane.showMessageDialog(rootPanel, "Template subject is empty.");
                }
                else if (messageField.getText().isEmpty()) {
                    JOptionPane.showMessageDialog(rootPanel, "Template message is empty.");
                }
                else {
                    TemplateLogic.insertTemplate(subjectField.getText(), messageField.getText(), nameField.getText());
                    JOptionPane.showMessageDialog(rootPanel, "       Template Saved");
                }
            }

        });

        // ActionListener to close the GUI when "Close" button is clicked
        closeButton.addActionListener(e -> TemplateMain.closeFrame()); //Close button closes the frame.
    }

    /**
     * Method to add Arraylist of Name to the nameComboBox
     */
    private void createNameCombo() {
        ArrayList<TemplateLogic> templates = TemplateLogic.getAllFields();
        for (TemplateLogic template : templates) {
            nameComboBox.addItem(template);
        }
        class itemStateChanged implements ItemListener {
            @Override
            public void itemStateChanged(ItemEvent e) {
                if (e.getStateChange() == ItemEvent.SELECTED) {

                    TemplateLogic item = (TemplateLogic) e.getItem();
                    nameField.setText(item.getName());
                    subjectField.setText(item.getSubject());
                    messageField.setText(item.getMessage());
                }
            }
        }
        nameComboBox.addItemListener(new itemStateChanged());
    }

    /**
     * getter method to return rootPanel
     */
    public JPanel getRootPanel(){
        return rootPanel;
    }


    private void createUIComponents() {
        // TODO: place custom component creation code here
    }

}
