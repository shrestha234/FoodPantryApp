package main;

/**Author: Kelly Nair
 * Date: 5/5/2020
 * Notification log of messages sent to users.
 * main class for the review notification log
 * Date:  5/16/2020
 * Deleted Message class
 * Included centering of jframe on screen
 * Date:  6/6/2020
 * Included closeFrame method to close the frame
 */

import ui.NotificationLogUI;

import javax.swing.*;
import javax.swing.plaf.RootPaneUI;

public class LogMain {

    public static JFrame rootFrame;

    public static void main(String[] args) {
        SwingUtilities.invokeLater(new Runnable() {
            @Override
            public void run() {
                createGUI();
            }
        });
    }
    public static void createGUI() {
            NotificationLogUI ui = new NotificationLogUI();
            JFrame frame = new JFrame("Notification Log");
            frame.setDefaultCloseOperation(JFrame.DISPOSE_ON_CLOSE);
            frame.setContentPane(ui.rootPanel);
            frame.pack();
            frame.setLocationRelativeTo(null);                  //centers ui on screen
            frame.setSize(850,400);               //a larger size to subject/messages were readable upon opening
            frame.setLocationRelativeTo(null);                 //Center the jframe on screen
            frame.setVisible(true);
            rootFrame = frame;
    }
    public static void closeFrame(){
        rootFrame.dispose();
    }
}