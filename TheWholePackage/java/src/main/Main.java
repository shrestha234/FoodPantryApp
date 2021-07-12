package main;

import ui.MainUI;
import javax.swing.*;

/**
 * Launch the MainUI GUI
 * @author Brandon Rankin
 */
public class Main {

    public static void main(String[] args){
        SwingUtilities.invokeLater(new Runnable(){
            @Override
            public void run(){
                createGUI();
            }
        });
    }

    private static void createGUI(){
        MainUI ui = new MainUI();
        JPanel root = ui.getRootPanel();
        JFrame frame = new JFrame("Food Insecurity App");
        frame.setDefaultCloseOperation(JFrame.EXIT_ON_CLOSE);
        frame.setContentPane(root);
        frame.pack();
        frame.setLocationRelativeTo(null);
        frame.setVisible(true);
    }
}
