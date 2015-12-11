
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.Date;
import java.util.logging.Level;
import java.util.logging.Logger;
//import Account;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//package sw_arch_pp;

/**
 *
 * @author narendramallela
 */
public class Customer extends Person{
    
    private ArrayList<Integer> accountsList;

    public Customer(ArrayList<Integer> accountsList, String fname, String lname, String username, String password, long ssn, String address, Date dob, String state, int zip, String city, String email, char gender, String bankname, String Address) {
        super(fname, lname, username, password, ssn, address, dob, state, zip, city, email, gender, bankname, Address);
        this.accountsList = accountsList;
    }

    public Customer() {
        accountsList = new ArrayList<Integer>();
    }
    
    public void setAccountsList()
    {
        SQLiteJDBC db = new SQLiteJDBC();
        db.openConn();
        Statement stmt = null;
        ResultSet rs = null;
        this.accountsList.clear();
        
         try {
            /**
             * harvesting customer's information from person table
             */
            stmt = db.c.createStatement();
            rs = stmt.executeQuery("SELECT * FROM Account WHERE ssn = "+ this.getSsn() +";");
            while (rs.next()) { //if user found
                this.accountsList.add(rs.getInt("accountnumber"));
                
            }
            
            rs.close(); 
            stmt.close();
            
        } catch (SQLException ex) {
            Logger.getLogger(Admin.class.getName()).log(Level.SEVERE, null, ex);
        }
    }
    
    public ArrayList<Integer> getAccountsList(){
        
        return this.accountsList;
    }
    
    
    
    
    
}
