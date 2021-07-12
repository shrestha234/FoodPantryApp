package main;


import ui.TemplateLogInUI;
import javax.swing.*;

/** Programmer Name: Bhupesh Shrestha
 *  Main class for Template Login page
 *  Date 06/06/2020
 *  Class to lunch the Template Creation Form from TemplateMain class
 */

public class TemplateMainLogIn {

    public static void main(String[] args){
        SwingUtilities.invokeLater(new Runnable(){
            @Override
            public void run(){
                createGUI();
            }
        });
    }

    private static void createGUI(){

        JFrame frame = new JFrame("Template");
        frame.setDefaultCloseOperation(JFrame.DISPOSE_ON_CLOSE);
        frame.getContentPane().add(new TemplateLogInUI().getRootPanel());
        frame.pack();
        frame.setVisible(true);
        frame.setLocationRelativeTo(null);

    }

}
