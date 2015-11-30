
import java.util.Scanner;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//package sw_arch_pp;
/**
 *
 * @author anokbakn
 */
public class BankSystem {

    private static String username;
    private static String password;
    private static Person user = new Person();

    public BankSystem(String username, String password) {
        this.username = username;
        this.password = password;
        this.user = new Person();
    }

    public BankSystem() {
        this.username = "";
        this.password = "";
        this.user = new Person();
    }

    public static void main(String[] args) {

        //BankSystem bankSystem = new BankSystem();
        System.out.println("Welcome to the Bank System");
        System.out.println("");

        Scanner in = new Scanner(System.in);
        System.out.println("");

        String loginResult = "";

        do {
            System.out.println("Please login.");
            System.out.println("Enter username: ");
            BankSystem.username = in.next();
            System.out.println("Enter password: ");
            BankSystem.password = in.next();

            //CODE TO LOG THEM IN HERE
            /**
             * this login method sets the user's information
			*
             */
            loginResult = BankSystem.user.login(username, password);
        } while (!(loginResult.equalsIgnoreCase("c") || loginResult.equalsIgnoreCase("a")));

        if (loginResult.equalsIgnoreCase("c")) {
            System.out.println("Welcome " + BankSystem.username + "! (Customer)");
            Customer customer = new Customer();
            //setting the customer variables equal to the current user's variables
            customer.setFname(user.getFname());
            customer.setLname(user.getLname());
            customer.setUsername(user.getUsername());
            customer.setSsn(user.getSsn());

            while (true) {
                System.out.println("Here are your options: ");
                System.out.println("");
                System.out.println("-- Enter '1' to add funds (deposit).");
                System.out.println("-- Enter '2' to withdraw funds.");
                System.out.println("-- Enter '3' to transfer funds among your accounts.");
                System.out.println("-- Enter '4' to see your transactions log.");
                System.out.println("-- Enter any other number to logout/exit");
                System.out.println("");

                int choice = in.nextInt();
                Scanner lineReader = new Scanner(System.in);
                switch (choice) {
                    case 1:
                        System.out.println("Please choose between these accounts: ");
                        //setting the customer's list of accounts
                        customer.setAccountsList();
                        System.out.println(customer.getAccountsList());
                        int accountNumb = in.nextInt();
                        Account account = new Account();
                        System.out.println("enter amount WITHOUT the dollar sign ($)");
                        float amount = in.nextFloat();
                        float newBalance = account.deposit(accountNumb, amount);
                        System.out.println("Funds successfully added!");
                        //System.out.println("Your new balance is: "+ newBalance);
                        System.out.println("Thank you.");
                        
                        break;
                    case 2:
                        System.out.println("Please choose between these accounts: ");
                        //setting the customer's list of accounts
                        customer.setAccountsList();
                        System.out.println(customer.getAccountsList());
                        int accountNumb2 = in.nextInt();
                        Account account2 = new Account();
                        System.out.println("enter amount WITHOUT the dollar sign ($)");
                        float amount2 = in.nextFloat();
                        boolean withdrawn = account2.withdraw(accountNumb2, amount2);
                        if(withdrawn){
                            System.out.println("Funds successfully withdrawn!");
                            System.out.println("Your balance is: "+ account2.getBalance());
                            System.out.println("Thank you.");
                        }else{
                            System.out.println("You don't have enough funds to make this transaction!");
                            System.out.println("Please try again when you have enough funds.");
                        }
                        
                        break;
                    case 3:
                        System.out.println("Here is the list of your accounts: ");
                        //setting the customer's list of accounts
                        customer.setAccountsList();
                        System.out.println(customer.getAccountsList());
                        System.out.println("--Enter source account for transfer--");
                        int source = in.nextInt();
                        System.out.println("--Enter destination account for transfer--");
                        int destination = in.nextInt();
                        System.out.println("--Enter amount for transfer--");
                        int transferAmount = in.nextInt();
                        
                        System.out.println("--Proceeding with withdrawal from source account--");
                        Account sourceAccount = new Account();
                        
                        boolean withdrawn2 = sourceAccount.withdraw(source, transferAmount);
                        if(withdrawn2){
                            System.out.println("Funds successfully withdrawn!");
                            System.out.println("Your balance is: "+ sourceAccount.getBalance());
                            System.out.println("Thank you.");
                            
                            System.out.println("--Proceeding with deposit to destination account--");
                            Account destinationAccount = new Account();
                            destinationAccount.deposit(destination, transferAmount);
                            System.out.println("Funds successfully transferred!");
                        
                            System.out.println("Thank you.");
                            
                        }else{
                            System.out.println("You don't have enough funds to make this transaction!");
                            System.out.println("Please try again when you have enough funds.");
                        }
                        
                        break;
                    case 4:
                        System.out.println("Which one of these accounts do you need the logs for: ");
                        //setting the customer's list of accounts
                        customer.setAccountsList();
                        System.out.println(customer.getAccountsList());
                        
                        int accountNumber4 = in.nextInt();
                        Account account4 = new Account();
                        account4.viewTransactionLog(accountNumber4);
                        
                        System.out.println("");
                        System.out.println("We appreciate your business!");
                        
                        break;

                    default:
                        System.out.println("");
                        System.out.println("-- Thank you for using this Bank System, goodbye! --");
                        System.exit(0);

                }
            }

        } else if (loginResult.equalsIgnoreCase("a")) {
            System.out.println("Welcome " + BankSystem.username + "! (Admin)");
            //creating an admin object
            Admin admin = new Admin();
            //setting variables
            admin.setFname(user.getFname());
            admin.setLname(user.getLname());
            admin.setUsername(user.getUsername());
            admin.setSsn(user.getSsn());

            while (true) {
                System.out.println("Here are your options: ");
                System.out.println("");
                System.out.println("-- Enter '1' to create new customer.");
                System.out.println("-- Enter '2' to assign accounts to customers.");
                System.out.println("-- Enter '3' to view system log.");
                System.out.println("-- Enter '4' to list all account numbers, customers and balances.");
                System.out.println("-- Enter '5' to suspend account.");
                System.out.println("-- Enter any other number to logout/exit");

                int choice = in.nextInt();
                Scanner lineReader = new Scanner(System.in);
                switch (choice) {
                    case 1:
                        System.out.println("--Enter customer first name:");
                        String fname = in.next();
                        System.out.println("--Enter customer last name:");
                        String lname = in.next();
                        System.out.println("--Enter password:");
                        String pwd = in.next();
                        System.out.println("--Enter customer SSN without spaces and special characters:");
                        long ssn = in.nextLong();
                        System.out.println("--Enter customer Phone number:");
                        String phone = in.next();
                        System.out.println("--Enter customer address:");
                        String address = lineReader.nextLine();//ENTER PATTERN
                        System.out.println("--Enter customer date of birth in this format dd-MM-yyyy:");
                        String dob = in.next();
                        System.out.println("--Enter customer state:");
                        String state = lineReader.nextLine();
                        System.out.println("--Enter customer zip code:");
                        int zip = in.nextInt();
                        System.out.println("--Enter customer city:");
                        String city = in.next();
                        System.out.println("--Enter customer email:");
                        String email = in.next();
                        System.out.println("--Enter customer gender (M or F):");
                        String gender = in.next();

                        boolean success = admin.createCustomer(fname, lname, pwd, ssn, phone, address,
                                dob, state, zip, city, email, gender);
                        if (success) {
                            System.out.println("Customer has been added.");
                            System.out.println("The customer username is : " + fname.concat(lname));
                            System.out.println("");
                        }
                        break;
                    case 2:
                        System.out.println("");
                        System.out.println("--Enter customer SSN without spaces and special characters:");
                        long ssn2 = in.nextLong();
                        String type = "";
                        do {
                            if (type.equalsIgnoreCase("c") || type.equalsIgnoreCase("s")) {
                                //do nothing
                            } else {
                                System.out.println("--Enter type of account C for checking and S for savings");
                                type = in.next();
                            }
                        } while (!(type.equalsIgnoreCase("c") || type.equalsIgnoreCase("s")));

                        boolean success2 = admin.assignAccountToCustomer(ssn2, type, admin.getSsn());
                        if (success2) {
                            System.out.println("Account has been added.");

                            System.out.println("");
                        } else {
                            System.out.println("Account has not been added.");

                            System.out.println("");
                        }

                        break;
                    case 3:
                        System.out.println("System log: ");
                        //to display system log
                        admin.viewSystemLog();
                        
                        break;
                    case 4:
                        System.out.println("Account log: ");
                        //to display accounts log
                        admin.viewSystemAccounts();
                        break;
                    case 5:
                        System.out.println("Please enter ssn of customer to delete: ");
                        long ssn6 = in.nextLong();
                        admin.suspendCustomer(ssn6);
                        break;
                    default:
                        System.out.println("");
                        System.out.println("-- Thank you for using this Bank System, goodbye! --");
                        System.exit(0);
                }
            }
        }

    }// end of main

}
