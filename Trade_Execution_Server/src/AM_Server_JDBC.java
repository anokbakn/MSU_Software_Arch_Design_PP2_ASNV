
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.logging.Level;
import java.util.logging.Logger;


/**
 *This class helps the TE_Server connect to the legacy banking db (AM_Server)
 * 
 * @author Armand Nokbak
 */
public class AM_Server_JDBC {
    
    protected Connection c = null;
    protected Statement stmt = null;

    public void openConn() {

        try {
            Class.forName("org.sqlite.JDBC");
            //String path = this.getClass().getResource("BAMS7.db").getPath();
            c = DriverManager.getConnection("jdbc:sqlite:BAMS7.db");
            //System.out.println("Opened database successfully");

        } catch (Exception e) {
            System.err.println(e.getClass().getName() + ": " + e.getMessage());
            //System.exit(0);
        }

    }
    
    public void closeConn(){
        
        try {
            c.close();
        } catch (SQLException ex) {
            Logger.getLogger(AM_Server_JDBC.class.getName()).log(Level.SEVERE, null, ex);
        }
    }
    
    
    
}
