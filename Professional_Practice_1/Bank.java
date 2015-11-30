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
public class Bank {
    
    private String bankname;
    private String Address;

    public Bank(String bankname, String Address) {
        this.bankname = bankname;
        this.Address = Address;
    }

    public Bank() {
    }
    
    public String getBankname() {
        return bankname;
    }

    public void setBankname(String bankname) {
        this.bankname = bankname;
    }

    public String getAddress() {
        return Address;
    }

    @Override
    public String toString() {
        return "Bank{" + "bankname=" + bankname + ", Address=" + Address + '}';
    }

    
    public void setAddress(String Address) {
        this.Address = Address;
    }
    
    
    
    
}
