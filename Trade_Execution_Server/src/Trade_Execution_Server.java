
import java.io.IOException;
import java.io.ObjectInputStream;
import java.io.ObjectOutputStream;
import java.net.InetAddress;
import java.net.Socket;
import java.net.UnknownHostException;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.swing.JOptionPane;



/**
 *
 * @author Armand Nokbak
 */
public class Trade_Execution_Server extends javax.swing.JFrame {

    
    /**
     * Creates new form Trade_Execution_Server
     */
    public Trade_Execution_Server() {
        initComponents();
    }

    /**
     * This method is called from within the constructor to initialize the form.
     * WARNING: Do NOT modify this code. The content of this method is always
     * regenerated by the Form Editor.
     */
    @SuppressWarnings("unchecked")
    // <editor-fold defaultstate="collapsed" desc="Generated Code">//GEN-BEGIN:initComponents
    private void initComponents() {

        connectButton = new javax.swing.JButton();
        stopAMServer = new javax.swing.JButton();

        setDefaultCloseOperation(javax.swing.WindowConstants.EXIT_ON_CLOSE);
        setTitle("Trade Execution Server");

        connectButton.setFont(new java.awt.Font("Times New Roman", 0, 12)); // NOI18N
        connectButton.setMnemonic('c');
        connectButton.setText("Connect to Account Management Server");
        connectButton.setToolTipText("Connect to AM server");
        connectButton.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                connectButtonActionPerformed(evt);
            }
        });

        stopAMServer.setFont(new java.awt.Font("Times New Roman", 0, 12)); // NOI18N
        stopAMServer.setText("Stop AM Server");
        stopAMServer.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                stopAMServerActionPerformed(evt);
            }
        });

        javax.swing.GroupLayout layout = new javax.swing.GroupLayout(getContentPane());
        getContentPane().setLayout(layout);
        layout.setHorizontalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(layout.createSequentialGroup()
                .addGap(150, 150, 150)
                .addComponent(connectButton)
                .addGap(150, 150, 150))
            .addGroup(javax.swing.GroupLayout.Alignment.TRAILING, layout.createSequentialGroup()
                .addContainerGap()
                .addComponent(stopAMServer)
                .addGap(30, 30, 30))
        );
        layout.setVerticalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(layout.createSequentialGroup()
                .addGap(95, 95, 95)
                .addComponent(connectButton)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED, 129, Short.MAX_VALUE)
                .addComponent(stopAMServer)
                .addGap(30, 30, 30))
        );

        pack();
    }// </editor-fold>//GEN-END:initComponents

    private void connectButtonActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_connectButtonActionPerformed
        /**
        * some of the client definition is inspired from the code found on 
        * http://www.journaldev.com/741/java-socket-server-client-read-write-example
        * **/
        try {
            InetAddress  host = InetAddress.getLocalHost();
            Socket socket = null;
            ObjectOutputStream outputStream = null;
            ObjectInputStream inputStream = null;
            
            //establish socket connection to server
            socket = new Socket(host.getHostName(), 1025);
            //write to socket using ObjectOutputStream
            outputStream = new ObjectOutputStream(socket.getOutputStream());
            outputStream.writeObject("Hello");
            
            
            inputStream.close();
            outputStream.close();
            socket.close();



        } catch (UnknownHostException ex) {
            showMessage("UnKnow Host");
        } catch (IOException ex) {
            showMessage("IO exception");
        }
    }//GEN-LAST:event_connectButtonActionPerformed

    private void stopAMServerActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_stopAMServerActionPerformed
        /**
        * some of the client definition is inspired from the code found on 
        * http://www.journaldev.com/741/java-socket-server-client-read-write-example
        * **/
        try {
            InetAddress  host = InetAddress.getLocalHost();
            Socket socket = null;
            ObjectOutputStream outputStream = null;
            ObjectInputStream inputStream = null;
            
            //establish socket connection to server
            socket = new Socket(host.getHostName(), 1025);
            //write to socket using ObjectOutputStream
            outputStream = new ObjectOutputStream(socket.getOutputStream());
            outputStream.writeObject("exit");
            
            inputStream.close();
            outputStream.close();
            socket.close();


        } catch (UnknownHostException ex) {
            showMessage("UnKnow Host");
        } catch (IOException ex) {
            showMessage("IO exception");
        }
    }//GEN-LAST:event_stopAMServerActionPerformed

    /**
     * @param args the command line arguments
     * 
     * 
     */
    public static void main(String args[]){
        /* Set the Nimbus look and feel */
        //<editor-fold defaultstate="collapsed" desc=" Look and feel setting code (optional) ">
        /* If Nimbus (introduced in Java SE 6) is not available, stay with the default look and feel.
         * For details see http://download.oracle.com/javase/tutorial/uiswing/lookandfeel/plaf.html 
         */
        try {
            for (javax.swing.UIManager.LookAndFeelInfo info : javax.swing.UIManager.getInstalledLookAndFeels()) {
                if ("Nimbus".equals(info.getName())) {
                    javax.swing.UIManager.setLookAndFeel(info.getClassName());
                    break;
                }
            }
        } catch (ClassNotFoundException ex) {
            java.util.logging.Logger.getLogger(Trade_Execution_Server.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        } catch (InstantiationException ex) {
            java.util.logging.Logger.getLogger(Trade_Execution_Server.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        } catch (IllegalAccessException ex) {
            java.util.logging.Logger.getLogger(Trade_Execution_Server.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        } catch (javax.swing.UnsupportedLookAndFeelException ex) {
            java.util.logging.Logger.getLogger(Trade_Execution_Server.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        }
        //</editor-fold>
        // getting the local ip address
        

        /* Create and display the form */
        java.awt.EventQueue.invokeLater(new Runnable() {
            public void run() {
                new Trade_Execution_Server().setVisible(true);
            }
        });
    }
    
    /**
     * displays an error message
     * @param errorMessage 
     */
    private void showMessage(String errorMessage) {
        
        JOptionPane.showMessageDialog(null, errorMessage, "Alert", JOptionPane.ERROR_MESSAGE);
    }
    
    /**
     * displays an information message
     * @param errorMessage 
     */
    private void showInfoMessage(String errorMessage) {
        
        JOptionPane.showMessageDialog(null, errorMessage, "Information", JOptionPane.INFORMATION_MESSAGE);
    }

    // Variables declaration - do not modify//GEN-BEGIN:variables
    private javax.swing.JButton connectButton;
    private javax.swing.JButton stopAMServer;
    // End of variables declaration//GEN-END:variables
}