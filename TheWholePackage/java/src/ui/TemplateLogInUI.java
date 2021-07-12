package ui;

import main.TemplateMain;

import javax.swing.*;
import java.awt.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;

/** Programmer Name: Bhupesh Shrestha
 *  ui class for Template login page
 *  date 06/06/2020
 */

public class TemplateLogInUI {
    private JPanel rootPanel;
    private JButton staffButton;
    private JButton managerButton;
    private JButton closeButton;


    public TemplateLogInUI(){
       rootPanel.setPreferredSize(new Dimension(500, 320));


       managerButton.addActionListener(actionEvent -> TemplateMain.createAndShow());


        closeButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                System.exit(0);
            }
        });
        staffButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                JOptionPane.showMessageDialog(rootPanel,"This service is unavailable");
            }
        });
    }

    public JPanel getRootPanel() {
        return rootPanel;
    }
}
