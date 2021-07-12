package main;

import ui.NotifyUI;
import javax.swing.*;

/**
 * 1) Launch the Notify GUI
 * 2) Take input of Notification information
 * 3) Send notification input to all subscribers
 * 4) Send notification input to notification log
 * @author Brandon Rankin
 */
public class NotifyMain {

    private static JFrame rootFrame;

    public static void main(String[] args){
        SwingUtilities.invokeLater(NotifyMain::createGUI);
    }

    public static void createGUI(){
        NotifyUI ui = new NotifyUI();
        JPanel root = ui.getRootPanel();
        JFrame frame = new JFrame("Send a Notification");
        frame.setDefaultCloseOperation(JFrame.DISPOSE_ON_CLOSE);
        frame.setContentPane(root);
        frame.pack();
        frame.setLocationRelativeTo(null);
        frame.setVisible(true);
        rootFrame = frame;
    }

    public static void closeFrame(){
        rootFrame.dispose();
    }
}
