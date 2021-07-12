package ui;

import main.NotifyMain;
import main.TemplateMain;
import main.LogMain;

import javax.swing.*;
import java.awt.*;

/**
 * Launch the Main GUI and open the other GUIs
 * @author Brandon Rankin
 */
public class MainUI {
    private JPanel rootPanel;
    private JButton subscribeButton;
    private JButton notifyButton;
    private JButton templateButton;
    private JButton logButton;
    private JButton closeButton;

    /** Create a MainUI object and listen for button clicks */
    public MainUI() {
        rootPanel.setPreferredSize(new Dimension(500, 450));
        JButton subscribeButton = new JButton();
        JFrame notYetImplementedFrame = new JFrame();

        // Listens for the "Create Account" button click
        subscribeButton.addActionListener(actionEvent -> {
            //TODO: Connect this to Abdullah's code
            JOptionPane.showMessageDialog(notYetImplementedFrame, "This application has not yet been implemented.");
        });

        // Listens for the "Send Notification" button click
        notifyButton.addActionListener(actionEvent -> NotifyMain.createGUI());

        // Listens for the "Create Template" button click
        templateButton.addActionListener(actionEvent -> TemplateMain.createAndShow());

        // Listens for the "View Notification Log" button click
        logButton.addActionListener(actionEvent -> LogMain.createGUI());

        // Listens for the "Close" button click
        closeButton.addActionListener(e -> System.exit(0));
    }

    /** @return rootPanel for main */
    public JPanel getRootPanel() {
        return rootPanel;
    }
}