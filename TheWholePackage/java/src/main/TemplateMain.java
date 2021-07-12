package main;

import ui.TemplateForm;

import javax.swing.*;

/** Programmer Name: Bhupesh Shrestha
 *  Main Method
 *  Date 05/27/2020
 */

public class TemplateMain {

    private static JFrame rootFrame;

    public static void createAndShow(){
        JFrame frame = new JFrame("Template");
        frame.setDefaultCloseOperation(JFrame.DISPOSE_ON_CLOSE);
        frame.getContentPane().add(new TemplateForm().getRootPanel());
        frame.pack();
        frame.setVisible(true);
        frame.setLocationRelativeTo(null);
        rootFrame = frame;
    }

    /**
     * main method is used to view the GUI
     */
    public static void main(String[] args){

        javax.swing.SwingUtilities.invokeLater(() -> createAndShow());

    }

    public static void closeFrame(){
        rootFrame.dispose();
    }
}
