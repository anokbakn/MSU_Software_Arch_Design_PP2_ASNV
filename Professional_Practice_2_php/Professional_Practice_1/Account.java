
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.Date;
import java.util.logging.Level;
import java.util.logging.Logger;

/**
 *
 * @author anokbakn
 */
public class Account extends Bank {

    String ownerFN;
    String ownerLN;
    long ownerSsn;
    long adminSsn;
    float balance;
    float minBalance;
    int accountNumber;
    Date creationDate;
    String type;

    public Account(String ownerFN, String ownerLN, long ownerSsn, long adminSsn, float balance, float minBalance, int accountNumber, Date creationDate, String type, String bankname, String Address) {
        super(bankname, Address);
        this.ownerFN = ownerFN;
        this.ownerLN = ownerLN;
        this.ownerSsn = ownerSsn;
        this.adminSsn = adminSsn;
        this.balance = balance;
        this.minBalance = minBalance;
        this.accountNumber = accountNumber;
        this.creationDate = creationDate;
        this.type = type;
    }

    public Account() {
        this.ownerFN = "";
        this.ownerLN = "";
        this.ownerSsn = 0;
        this.adminSsn = 0;
        this.balance = 0;
        this.minBalance = 0;
        this.accountNumber = 0;
        this.creationDate = null;
        this.type = "checking";
    }

    /**
     * this method deposits money in account and returns balance
     *
     * @param accountNumber
     * @param amount
     * @return this.balance
     */
    public float deposit(int accountNumber, float amount) {
        setAccountNumber(accountNumber);
        SQLiteJDBC db = new SQLiteJDBC();
        try {

            db.openConn();
            db.c.setAutoCommit(false);
            Statement stmt = null;
            ResultSet rs = null;

            stmt = db.c.createStatement();
            String sql = "UPDATE Account SET balance = balance + " + amount + " WHERE accountnumber = "
                    + accountNumber + ";";
            stmt.executeUpdate(sql);
            db.c.commit();

            rs = stmt.executeQuery("SELECT * FROM Account WHERE accountnumber = "
                    + accountNumber + ";");
            if (rs.next()) {
                while (rs.next()) {
                    this.setOwnerSsn(rs.getLong(3));
                    this.setBalance(rs.getFloat(4));
                }
            } else {
                System.out.println("Account number not in records!");
            }

            rs.close();
            stmt.close();
            db.c.close();
        } catch (SQLException ex) {
            Logger.getLogger(Account.class.getName()).log(Level.SEVERE, null, ex);
        }

        db.closeConn();
        
        /**
             * Recording the transactions
             */
            try {

                db.openConn();
                db.c.setAutoCommit(false);
                Statement stmt = null;
                

                stmt = db.c.createStatement();
                String sql = "INSERT INTO Bank_transaction (ssn, accountnumber, amount, type) "
                        + "VALUES (" + this.getOwnerSsn() + ", " + accountNumber
                        + ", " + amount + ", 'deposit' );";
                stmt.executeUpdate(sql);
                db.c.commit();

                
                stmt.close();
                db.c.close();
            } catch (SQLException ex) {
                Logger.getLogger(Account.class.getName()).log(Level.SEVERE, null, ex);
            }

            db.closeConn();
            
        

        return getBalance();

    }

    public boolean withdraw(int accountNumber, float amount) {
        boolean withdrawn = false;
        float currentBalance = 0;
        SQLiteJDBC db = new SQLiteJDBC();
        try {

            db.openConn();
            Statement stmt = null;
            ResultSet rs = null;

            stmt = db.c.createStatement();
            rs = stmt.executeQuery("SELECT * FROM Account WHERE accountnumber = " + accountNumber + ";");
            while (rs.next()) { //if user found
                this.setOwnerSsn(rs.getLong(3));
                this.setType(rs.getString(8));
                currentBalance = rs.getFloat(4);
                this.setBalance(currentBalance);
            }
            rs.close();

            db.closeConn();
        } catch (SQLException ex) {
            Logger.getLogger(Account.class.getName()).log(Level.SEVERE, null, ex);
        }

        if (currentBalance < amount) {
            withdrawn = false;
        } else {
            try {

                db.openConn();
                db.c.setAutoCommit(false);
                Statement stmt = null;
                

                stmt = db.c.createStatement();
                String sql = "UPDATE Account SET balance = balance - " + amount + " WHERE accountnumber = "
                        + accountNumber + ";";
                stmt.executeUpdate(sql);
                db.c.commit();

                
                stmt.close();
                db.c.close();
            } catch (SQLException ex) {
                Logger.getLogger(Account.class.getName()).log(Level.SEVERE, null, ex);
            }

            db.closeConn();
            
            this.setBalance(this.getBalance() - amount);
            withdrawn = true;
            
            /**
             * Recording the transactions
             */
            try {

                db.openConn();
                db.c.setAutoCommit(false);
                Statement stmt = null;
                

                stmt = db.c.createStatement();
                String sql = "INSERT INTO Bank_transaction (ssn, accountnumber, amount, type) "
                        + "VALUES (" + this.getOwnerSsn() + ", " + accountNumber
                        + ", " + amount + ", 'withdrawal' );";
                stmt.executeUpdate(sql);
                db.c.commit();

                
                stmt.close();
                db.c.close();
            } catch (SQLException ex) {
                Logger.getLogger(Account.class.getName()).log(Level.SEVERE, null, ex);
            }

            db.closeConn();
            
        }

        return withdrawn;
    }
    
    public void viewTransactionLog(int accountNumber){
        SQLiteJDBC db = new SQLiteJDBC();
        try {

            db.openConn();
            Statement stmt = null;
            ResultSet rs = null;

            stmt = db.c.createStatement();
            rs = stmt.executeQuery("SELECT * FROM Bank_transaction WHERE accountnumber = " + 
                    accountNumber + ";");
            while (rs.next()) { //if user found
                System.out.println();
                System.out.print(rs.getInt("accountnumber"));
                System.out.print(" "+ rs.getString("type"));
                System.out.print(" "+ rs.getFloat("amount"));
                
                
            }
            rs.close();

            db.closeConn();
        } catch (SQLException ex) {
            Logger.getLogger(Account.class.getName()).log(Level.SEVERE, null, ex);
        }
    }

    public String getOwnerFN() {
        return ownerFN;
    }

    public void setOwnerFN(String ownerFN) {
        this.ownerFN = ownerFN;
    }

    public String getOwnerLN() {
        return ownerLN;
    }

    public void setOwnerLN(String ownerLN) {
        this.ownerLN = ownerLN;
    }

    public long getOwnerSsn() {
        return ownerSsn;
    }

    public void setOwnerSsn(long ownerSsn) {
        this.ownerSsn = ownerSsn;
    }

    public long getAdminSsn() {
        return adminSsn;
    }

    public void setAdminSsn(long adminSsn) {
        this.adminSsn = adminSsn;
    }

    public float getBalance() {
        return balance;
    }

    public void setBalance(float balance) {
        this.balance = balance;
    }

    public float getMinBalance() {
        return minBalance;
    }

    public void setMinBalance(float minBalance) {
        this.minBalance = minBalance;
    }

    public int getAccountNumber() {
        return accountNumber;
    }

    public void setAccountNumber(int accountNumber) {
        this.accountNumber = accountNumber;
    }

    public Date getCreationDate() {
        return creationDate;
    }

    public void setCreationDate(Date creationDate) {
        this.creationDate = creationDate;
    }

    public String getType() {
        return type;
    }

    public void setType(String type) {
        this.type = type;
    }

}
