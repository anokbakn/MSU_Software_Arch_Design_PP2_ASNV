/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//package sw_arch_pp;

import java.sql.*;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.Date;
import java.util.logging.Level;
import java.util.logging.Logger;

/**
 *
 * @author anokbakn
 */
public class Person extends Bank{
    private String fname;
    private String lname;
    private String username;
    private String password;
    private long ssn;
    private String address;
    private Date dob;
    private String state;
    private int zip;
    private String city;
    private String email;
    private char gender;

    public Person(String fname, String lname, String username, String password, long ssn, String address, Date dob, String state, int zip, String city, String email, char gender, String bankname, String Address) {
        super(bankname, Address);
        this.fname = fname;
        this.lname = lname;
        this.username = username;
        this.password = password;
        this.ssn = ssn;
        this.address = address;
        this.dob = dob;
        this.state = state;
        this.zip = zip;
        this.city = city;
        this.email = email;
        this.gender = gender;
    }

    public Person() {
    }

    public String login(String username, String pwd){
        String result = "";
        
        SQLiteJDBC db = new SQLiteJDBC();
        //open db connection
        db.openConn();
        Statement stmt = null;
        ResultSet rs = null;
        try {
            db.c.setAutoCommit(false);
            stmt = db.c.createStatement();
            rs = stmt.executeQuery("SELECT * FROM Person WHERE USERNAME = '"+ username+"' AND PASSWORD = '"+ pwd +"';");
            
            //System.out.println(rs);
            
            while (rs.next()) { //if user found
                result = "c"; //user is customer
                this.username = rs.getString("username");
                this.fname = rs.getString("firstname");
                this.lname = rs.getString("lastname");
                this.address = rs.getString("address");
                this.email = rs.getString("email");
                this.state = rs.getString("state");
                this.city = rs.getString("city");
                //this.dob = rs.getDate("dob");
                this.ssn = rs.getLong("ssn");

            }
			
			/**
			CHECK IF USER IS ADMIN
			**/
			if(result.equalsIgnoreCase("c")){
				stmt = db.c.createStatement();
				rs = stmt.executeQuery("SELECT * FROM Admin WHERE ssn = "+ this.ssn +";");
				while ( rs.next() ) { //if user found
					result = "a"; //user is customer
				}
			}
            
            rs.close(); 
            stmt.close();
        } catch (SQLException ex) {
            Logger.getLogger(SQLiteJDBC.class.getName()).log(Level.SEVERE, null, ex);
        }
        
        //close db connection
        db.closeConn();
        
        return result;
    }
    
    public boolean logout(){
        
        
        return true;
    }

    public String getFname() {
        return fname;
    }

    public void setFname(String fname) {
        this.fname = fname;
    }

    public String getLname() {
        return lname;
    }

    public void setLname(String lname) {
        this.lname = lname;
    }

    public String getUsername() {
        return username;
    }

    public void setUsername(String username) {
        this.username = username;
    }

    public String getPassword() {
        return password;
    }

    public void setPassword(String password) {
        this.password = password;
    }

    public long getSsn() {
        return ssn;
    }

    public void setSsn(long ssn) {
        this.ssn = ssn;
    }

    public Date getDob() {
        return dob;
    }

    public void setDob(Date dob) {
        this.dob = dob;
    }

    public String getState() {
        return state;
    }

    public void setState(String state) {
        this.state = state;
    }

    public int getZip() {
        return zip;
    }

    public void setZip(int zip) {
        this.zip = zip;
    }

    public String getCity() {
        return city;
    }

    public void setCity(String city) {
        this.city = city;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public char getGender() {
        return gender;
    }

    public void setGender(char gender) {
        this.gender = gender;
    }
    
    
    
    
}
