

import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import java.util.logging.Level;
import java.util.logging.Logger;

/**
 *
 * @author Srikar Devarakonda
 */
/**
 * AN ADMIN INHERITS PROPERTIES FROM THE PERSON CLASS
 */
public class Admin extends Person {

    private ArrayList<Customer> adminsCustomer;
    private String employeeID;

    public Admin(ArrayList<Customer> adminsCustomer, String employeeID, String fname, String lname, String username, String password, long ssn, String address, Date dob, String state, int zip, String city, String email, char gender, String bankname, String Address) {
        super(fname, lname, username, password, ssn, address, dob, state, zip, city, email, gender, bankname, Address);
        this.adminsCustomer = adminsCustomer;
        this.employeeID = employeeID;
    }

    public Admin() {
        this.adminsCustomer = new ArrayList<Customer>();
        this.employeeID = "";
    }

    /**
     * This method helps create new customers
     *
     * @return result
     */
    public boolean createCustomer(String fname, String lname, String pwd, long ssn, String phone,
            String address, String dob, String state, int zip, String city, String email, String gender) {
        boolean result = false;
        //converting dob string into date object
        SimpleDateFormat formatter = new SimpleDateFormat("dd-MM-yyyy");
        String dateGiven = dob;
        Date date = null;
        try {
            date = formatter.parse(dateGiven);
        } catch (ParseException ex) {
            Logger.getLogger(Admin.class.getName()).log(Level.SEVERE, null, ex);
        }
        //java.util.Date utilDate = new java.util.Date();
        java.sql.Date sqlDate = new java.sql.Date(date.getTime());

        SQLiteJDBC db = new SQLiteJDBC();
        //open db connection
        db.openConn();
        Statement stmt = null;
        
        //getting MD5 value of password
        String md5Pwd = convertPasswordToMD5(pwd);

        try {
            stmt = db.c.createStatement();
            //creating customer record in person table
            String sql = "INSERT INTO Person (firstname,lastname, username, password, ssn, phone, address, dob, state, zip, city, email,gender) "
                    + "VALUES ('" + fname + "', '" + lname + "','" + fname.concat(lname)
                    + "', '" + md5Pwd + "', " + ssn + ", '" + phone + "','" + address + "'," + sqlDate + ",'" + state
                    + "'," + zip + ",'" + city + "','" + email + "','" + gender + "' );";
            stmt.executeUpdate(sql);
            //creating customer record in customer table
            sql = "INSERT INTO Customer (ssn,username) "
                    + "VALUES (" + ssn + ", '" + fname.concat(lname) + "' );";
            stmt.executeUpdate(sql);

            result = true;
            stmt.close();
        } catch (SQLException ex) {
            Logger.getLogger(Admin.class.getName()).log(Level.SEVERE, null, ex);
            result = false;
        }
        db.closeConn();

        return result;
    }

    /**
     * This method creates new accounts for customers
     *
     * @return assigned
     */
    public boolean assignAccountToCustomer(long customerSsn, String type, long adminSsn) {
        boolean assigned = false;
        boolean found = false;
        Customer customer = new Customer(); //new customer object
        SQLiteJDBC db = new SQLiteJDBC();
        db.openConn();
        Statement stmt = null;
        ResultSet rs = null;

        java.sql.Date today = new java.sql.Date(Calendar.getInstance().getTime().getTime());

        try {
            /**
             * harvesting customer's information from person table
             */
            stmt = db.c.createStatement();
            rs = stmt.executeQuery("SELECT * FROM Person WHERE ssn = " + customerSsn + ";");
            while (rs.next()) { //if user found

                customer.setUsername(rs.getString("username"));
                customer.setFname(rs.getString("firstname"));
                customer.setLname(rs.getString("lastname"));
                customer.setAddress(rs.getString("address"));
                found = true;
            }

            rs.close();

            if (found) {
                if (type.equalsIgnoreCase("c")) {
                    type = "checking";
                } else if (type.equalsIgnoreCase("s")) {
                    type = "savings";
                } else if (type.equalsIgnoreCase("b")) {
                    type = "brokerage";
                }
                //creating customer record in customer table
                String sql = "INSERT INTO Account (ownerFN, ownerLN, ssn, balance, creationdate, Admin_id, type) "
                        + "VALUES ('" + customer.getFname() + "', '" + customer.getLname()
                        + "', " + customerSsn + ", " + 0 + ", " + today + " , " + adminSsn + ", '" + type + "' );";
                stmt.executeUpdate(sql);
                /////////////////////////////////////////////////////////////////////////////////////////////////
                //add brokerage account to brokerage_account table in db
                if(type.equalsIgnoreCase("brokerage")){
                    //the brokerage accountnumber of the account being created
                    int brokerage_account_numb = 0;
                    //getting the brokerage account's number fromAccount table
                    rs = stmt.executeQuery("SELECT * FROM Account WHERE ssn="+ customerSsn +" AND type = 'brokerage' AND Admin_id = "+ adminSsn +";");
                    while (rs.next()) { //if user found
                        brokerage_account_numb = rs.getInt("accountnumber");
                    }
                    rs.close();
                    
                    String sql2 = "INSERT INTO brokerage_account (accountnumber, currentprofit, currentlost) "
                        + "VALUES (" + brokerage_account_numb + ", " + 0 + ", " + 0 + " );";
                    stmt.executeUpdate(sql2);
                
                }
                
                assigned = true;
            } else {
                assigned = false;
            }
            stmt.close();

        } catch (SQLException ex) {
            Logger.getLogger(Admin.class.getName()).log(Level.SEVERE, null, ex);
        }

        db.closeConn();

        return assigned;
    }

    /**
     * this method takes in a password and returns its MD5 value
     * inspired from code at http://www.mkyong.com/java/java-md5-hashing-example/
     * 
     * @param password
     * @return 
     */
    public String convertPasswordToMD5(String password){
        StringBuffer sb = null;
        try {
            MessageDigest md = MessageDigest.getInstance("MD5");
            md.update(password.getBytes());
            
            byte byteData[] = md.digest();
            
            //convert the byte to hex format method 1
            sb = new StringBuffer();
            for (int i = 0; i < byteData.length; i++) {
                sb.append(Integer.toString((byteData[i] & 0xff) + 0x100, 16).substring(1));
            }
            
            
        } catch (NoSuchAlgorithmException ex) {
            Logger.getLogger(Admin.class.getName()).log(Level.SEVERE, null, ex);
        }

        return sb.toString();
    }
    
    public void viewSystemAccounts() {
        SQLiteJDBC db = new SQLiteJDBC();
        try {

            db.openConn();
            Statement stmt = null;
            ResultSet rs = null;

            stmt = db.c.createStatement();
            rs = stmt.executeQuery("SELECT * FROM Account;");
            while (rs.next()) { //if user found
                System.out.println();
                System.out.print("Account Number" + rs.getInt("accountnumber"));
                System.out.print(" First Name: " + rs.getString("ownerFN"));
                System.out.print(" Last Name: " + rs.getString("ownerLN"));
                System.out.print(" Balance: " + rs.getFloat(4));

            }
            rs.close();
            System.out.println("");
            db.closeConn();
        } catch (SQLException ex) {
            Logger.getLogger(Account.class.getName()).log(Level.SEVERE, null, ex);
        }
    }

    public void viewSystemLog() {
        SQLiteJDBC db = new SQLiteJDBC();
        try {

            db.openConn();
            Statement stmt = null;
            ResultSet rs = null;

            stmt = db.c.createStatement();
            rs = stmt.executeQuery("SELECT * FROM Bank_transaction;");
            while (rs.next()) { //if user found
                System.out.println();
                System.out.print("Account Number: " + rs.getInt("accountnumber"));
                System.out.print(" Account Type: " + rs.getString("type"));
                System.out.print(" Amount: " + rs.getFloat("amount"));

            }
            rs.close();
            System.out.println("");
            db.closeConn();
        } catch (SQLException ex) {
            Logger.getLogger(Account.class.getName()).log(Level.SEVERE, null, ex);
        }
    }

    public boolean suspendCustomer(long ssn) {
        SQLiteJDBC db = new SQLiteJDBC();
        db.openConn();
        boolean success = false;
        try {
            Statement stmt = null;

            db.c.setAutoCommit(false);
            
            stmt = db.c.createStatement();
            String sql = "DELETE from Person where ssn=" + ssn + ";";
            stmt.executeUpdate(sql);
            db.c.commit();

            stmt.close();
            db.c.close();

            success = true;
        } catch (SQLException ex) {
            Logger.getLogger(Admin.class.getName()).log(Level.SEVERE, null, ex);
            success = false;
        }
        db.closeConn();
        System.out.println("Account suspended.");
        System.out.println("");
        return success;
    }

}
