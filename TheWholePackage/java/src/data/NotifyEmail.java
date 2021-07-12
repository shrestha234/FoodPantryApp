package data;

import javax.mail.Message;
import javax.mail.PasswordAuthentication;
import javax.mail.Session;
import javax.mail.Transport;
import javax.mail.internet.AddressException;
import javax.mail.internet.InternetAddress;
import javax.mail.internet.MimeMessage;
import java.util.Properties;

public class NotifyEmail {

    /** Sends the notification to all the emails in the user database */
    public void sendEmails(String toEmails, String notifySubject, String notifyMessage) {
        final String username = "cis234a2020@gmail.com";
        final String password = "TheWholePackage234!";

        Properties props = new Properties();

        props.put("mail.smtp.auth", "true");
        props.put("mail.smtp.starttls.enable", "true");
        props.put("mail.smtp.host", "smtp.gmail.com");
        props.put("mail.smtp.port", "587");

        Session session = Session.getInstance(props,
                new javax.mail.Authenticator() {
                    protected PasswordAuthentication getPasswordAuthentication() {
                        return new PasswordAuthentication(username, password);
                    }
                });
        try {
            Message message = new MimeMessage(session);
            message.setFrom(new InternetAddress("cis234a2020@gmail.com"));
            message.setRecipients(Message.RecipientType.BCC,
                    InternetAddress.parse(toEmails));
            message.setSubject(notifySubject);
            message.setText(notifyMessage);
            //message.setDataHandler(new DataHandler(notifyMessage, "text/html"));

            Transport.send(message);

        } catch (AddressException e) {
            throw new RuntimeException(e);
        } catch (javax.mail.MessagingException e) {
            e.printStackTrace();
        }
    }
}
