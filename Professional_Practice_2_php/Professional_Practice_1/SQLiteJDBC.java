
import java.sql.*;
import java.util.logging.Level;
import java.util.logging.Logger;

public class SQLiteJDBC {

    protected Connection c = null;
    protected Statement stmt = null;

    public void openConn() {

        try {
            Class.forName("org.sqlite.JDBC");
            String path = this.getClass().getResource("BAMS7.db").getPath();
            c = DriverManager.getConnection("jdbc:sqlite:" + path);
            //System.out.println("Opened database successfully");

        } catch (Exception e) {
            System.err.println(e.getClass().getName() + ": " + e.getMessage());
            System.exit(0);
        }

    }
    
    public void closeConn(){
        
        try {
            c.close();
        } catch (SQLException ex) {
            Logger.getLogger(SQLiteJDBC.class.getName()).log(Level.SEVERE, null, ex);
        }
    }
    
    
    
}
