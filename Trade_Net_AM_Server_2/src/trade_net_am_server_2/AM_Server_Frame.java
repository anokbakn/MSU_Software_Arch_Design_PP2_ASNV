package trade_net_am_server_2;

import java.io.IOException;
import java.io.ObjectInputStream;
import java.net.ServerSocket;
import java.net.Socket;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.swing.JOptionPane;



/**
 *
 * @author Armand Nokbak
 */
public class AM_Server_Frame extends javax.swing.JFrame {
    
    //static server socket
    private static ServerSocket amServer;
    //the port number for the AM Server
    private static int amPort = 1025;
    

    /**
     * Creates new form AM_Server_Frame
     */
    public AM_Server_Frame() {
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

        startButton = new javax.swing.JButton();
        statusLabel = new javax.swing.JLabel();

        setDefaultCloseOperation(javax.swing.WindowConstants.EXIT_ON_CLOSE);
        setTitle("Account Management Server");

        startButton.setBackground(new java.awt.Color(255, 255, 255));
        startButton.setFont(new java.awt.Font("Times New Roman", 1, 12)); // NOI18N
        startButton.setMnemonic('s');
        startButton.setText("Start Account Management Server");
        startButton.setToolTipText("start AM server");
        startButton.addActionListener(new java.awt.event.ActionListener() {
            public void actionPerformed(java.awt.event.ActionEvent evt) {
                startButtonActionPerformed(evt);
            }
        });

        statusLabel.setBackground(new java.awt.Color(255, 255, 255));
        statusLabel.setFont(new java.awt.Font("Tw Cen MT", 0, 14)); // NOI18N
        statusLabel.setForeground(new java.awt.Color(0, 0, 255));
        statusLabel.setHorizontalAlignment(javax.swing.SwingConstants.CENTER);
        statusLabel.setText("Account Management Server stopped");
        statusLabel.setBorder(javax.swing.BorderFactory.createTitledBorder(null, "Server Status: ", javax.swing.border.TitledBorder.DEFAULT_JUSTIFICATION, javax.swing.border.TitledBorder.DEFAULT_POSITION, new java.awt.Font("Bookman Old Style", 2, 10))); // NOI18N
        statusLabel.setOpaque(true);

        javax.swing.GroupLayout layout = new javax.swing.GroupLayout(getContentPane());
        getContentPane().setLayout(layout);
        layout.setHorizontalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(layout.createSequentialGroup()
                .addGap(150, 150, 150)
                .addComponent(startButton)
                .addContainerGap(150, Short.MAX_VALUE))
            .addGroup(javax.swing.GroupLayout.Alignment.TRAILING, layout.createSequentialGroup()
                .addContainerGap()
                .addComponent(statusLabel, javax.swing.GroupLayout.DEFAULT_SIZE, javax.swing.GroupLayout.DEFAULT_SIZE, Short.MAX_VALUE)
                .addContainerGap())
        );
        layout.setVerticalGroup(
            layout.createParallelGroup(javax.swing.GroupLayout.Alignment.LEADING)
            .addGroup(layout.createSequentialGroup()
                .addGap(150, 150, 150)
                .addComponent(startButton)
                .addPreferredGap(javax.swing.LayoutStyle.ComponentPlacement.RELATED, 109, Short.MAX_VALUE)
                .addComponent(statusLabel, javax.swing.GroupLayout.PREFERRED_SIZE, 71, javax.swing.GroupLayout.PREFERRED_SIZE)
                .addContainerGap())
        );

        pack();
    }// </editor-fold>//GEN-END:initComponents

    private void startButtonActionPerformed(java.awt.event.ActionEvent evt) {//GEN-FIRST:event_startButtonActionPerformed
        
        try {
            //create the AM Server socket object
            amServer = new ServerSocket(amPort);
            
            //keep listening
            while(true){
                //Let user know that AM Server is on
                showInfoMessage("Account Management Server started. Waiting for connection ...");
                //waiting for client connections
                Socket socket = amServer.accept();
                
                //read from socket to ObjectInputStream object
                ObjectInputStream inputStream = new ObjectInputStream(socket.getInputStream());
                //convert ObjectInputStream object to String
                String message = (String) inputStream.readObject();
                
                if(message.equalsIgnoreCase("exit")){
                        // close the server
                        amServer.close();
                        showInfoMessage("AM Server stopped successfully!");
                        break;
                }
                //else if(){
                    
                //}
                
                System.out.println("Message Received: " + message);

                //closing the socket
                socket.close();
                
            }//end of while true
            
            
                
        } catch (IOException ex) {
            String errorMessage = "Server could not be started,\nmake sure that port 1025 is available";
            showMessage(errorMessage);
        } catch (ClassNotFoundException ex) {
            Logger.getLogger(AM_Server_Frame.class.getName()).log(Level.SEVERE, null, ex);
        }
    }//GEN-LAST:event_startButtonActionPerformed

    /**
     * @param args the command line arguments
     */
    public static void main(String args[]) {
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
            java.util.logging.Logger.getLogger(AM_Server_Frame.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        } catch (InstantiationException ex) {
            java.util.logging.Logger.getLogger(AM_Server_Frame.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        } catch (IllegalAccessException ex) {
            java.util.logging.Logger.getLogger(AM_Server_Frame.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        } catch (javax.swing.UnsupportedLookAndFeelException ex) {
            java.util.logging.Logger.getLogger(AM_Server_Frame.class.getName()).log(java.util.logging.Level.SEVERE, null, ex);
        }
        //</editor-fold>

        /* Create and display the form */
        java.awt.EventQueue.invokeLater(new Runnable() {
            public void run() {
                new AM_Server_Frame().setVisible(true);
            }
        });
    }

    // Variables declaration - do not modify//GEN-BEGIN:variables
    private javax.swing.JButton startButton;
    private javax.swing.JLabel statusLabel;
    // End of variables declaration//GEN-END:variables

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
}
