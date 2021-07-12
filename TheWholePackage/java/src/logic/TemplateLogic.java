package logic;

import data.TemplateDatabase;

import java.util.ArrayList;


/** Programmer Name: Bhupesh Shrestha
 *  Logic Layer Class
 *  Date 06/06/2020
 */


public class TemplateLogic {

    private String name;
    private String subject;
    private String message;
    private int templateID;

    public TemplateLogic(String name, String subject, String message) {

        this.name = name;
        this.subject = subject;
        this.message = message;
    }
    
    public TemplateLogic(String name, String subject, String message, int templateID) {

        this.name = name;
        this.subject = subject;
        this.message = message;
        this.templateID = templateID;
    }

    public String toString(){
        return this.name;
    }

    public static void insertTemplate(String name, String subject, String message){
        TemplateDatabase.insertTemplate(name,subject,message);
    }

    public static ArrayList<TemplateLogic> getAllFields(){
        ArrayList<TemplateLogic> templates = TemplateDatabase.getAllFields();
        return templates;
    }

    public String getName() {
        return name;
    }

    public String getSubject() {
        return subject;
    }

    public String getMessage() {
        return message;
    }

    public int getTemplateID() {
        return templateID;
    }


}