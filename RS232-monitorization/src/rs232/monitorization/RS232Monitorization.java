/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

package rs232.monitorization;
import java.io.*;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.Time;
import java.util.*;
import javax.comm.*;

/**
 *
 * @author ciisp
 */
public class RS232Monitorization implements Runnable, SerialPortEventListener {
    
    static CommPortIdentifier portId;
    static Enumeration portList;
    private BufferedReader input;

    InputStream inputStream;
    SerialPort serialPort;
    Thread readThread;
    
    List<String[]> inputList = new ArrayList<>();
    

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        // TODO code application logic here
           portList = CommPortIdentifier.getPortIdentifiers();

        while (portList.hasMoreElements()) {
            portId = (CommPortIdentifier) portList.nextElement();
            if (portId.getPortType() == CommPortIdentifier.PORT_SERIAL) {
                 if (portId.getName().equals("COM13")) {
			//                if (portId.getName().equals("/dev/term/a")) {
                    RS232Monitorization reader = new RS232Monitorization();
                }
            }
        }
    
    }
     public RS232Monitorization() {
        try {
            serialPort = (SerialPort) portId.open("SimpleReadApp", 2000);
        } catch (PortInUseException e) {System.out.println(e);}
        try {
            inputStream = serialPort.getInputStream();
        } catch (IOException e) {System.out.println(e);}
	try {
            serialPort.addEventListener(this);
	} catch (TooManyListenersException e) {System.out.println(e);}
        serialPort.notifyOnDataAvailable(true);
        try {
            serialPort.setSerialPortParams(9600,
                SerialPort.DATABITS_8,
                SerialPort.STOPBITS_1,
                SerialPort.PARITY_NONE);
        } catch (UnsupportedCommOperationException e) {System.out.println(e);}
        readThread = new Thread(this);
        readThread.start();
    }

    public void run() {
        Timer timer = new Timer();
        
        timer.scheduleAtFixedRate(new TimerTask(){
            @Override
            public void run(){
                // Enviar dados ao servidor
                System.err.println("Envio de dados ao servidor");
                
                InsertDataInDB();
                
                
                // Limpar os dados da lista
                inputList = new ArrayList<>();
            }
        }, 10000, 10000);
        
        try {
            Thread.sleep(20000);
        } catch (InterruptedException e) {System.out.println(e);}
    }

    public void serialEvent(SerialPortEvent event) {
        switch(event.getEventType()) {
        case SerialPortEvent.BI:
        case SerialPortEvent.OE:
        case SerialPortEvent.FE:
        case SerialPortEvent.PE:
        case SerialPortEvent.CD:
        case SerialPortEvent.CTS:
        case SerialPortEvent.DSR:
        case SerialPortEvent.RI:
        case SerialPortEvent.OUTPUT_BUFFER_EMPTY:
            break;
        case SerialPortEvent.DATA_AVAILABLE:
            byte[] readBuffer = new byte[1];
           
            try {
                String input = "";
                String readChar = "";
                boolean newLine = false;
                
                // Read string until we reach a new line character
                while (!newLine) {
                    int numBytes = inputStream.read(readBuffer);
                    readChar = new String(readBuffer, 0, numBytes);
                    System.out.print(readChar);
                    input += readChar; 
                    
                    // Check if we're reaching a new line character
                    if(readChar.charAt(0) == '\r' || readChar.charAt(0) == '\n'){
                        newLine = true;
                    }
                }
                 
                //System.out.print(new String(readBuffer));
              
                String[] values = input.split(",");
                for(String str : values){
                    str = str.trim();
                    System.out.println(str);
                }
                
                inputList.add(values);
            
            } catch (IOException e) {System.out.println(e);}
            
            break;
            
        }
    }
    
    public void InsertDataInDB(){
        try{
            String myDriver = "com.mysql.jdbc.Driver";
            String myUrl = "jdbc:mysql://localhost:3306/plantdb?useSSL=false&serverTimezone=UTC";
            Class.forName(myDriver);
            Connection conn = DriverManager.getConnection(myUrl, "root", "");
            
           // Calendar calendar = Calendar.getInstance();
            //java.sql.Date startDate = (java.sql.Date) new Date();
            //long startTime = startDate.getTime();
            for (int i = 0; i <= inputList.size(); i++){
            String [] strings = inputList.get(i);
              
            for ( String [] s : inputList ){ 
                
                
           // String query = " insert into sensors (id_sensor, date, hour,temperature, ativo) "
                   // + "values (?, ?, ?, ?, ?)";
                String query = " insert into sensors (id_sensor, date, hour,temperature, humidity, pressure, altitude, ativo) "
                    + "values (?, ?, ?, ?, ?, ?, ?, ?)";
                String timeout = "timeout";
            if ( s[3].contains(timeout)) {
                
                PreparedStatement preparedStatement = conn.prepareStatement(query);
            preparedStatement.setString(1, s[2]);
            preparedStatement.setString(2, s[0]);
            preparedStatement.setString(3, s[1]);
            preparedStatement.setString(4, "0");
            preparedStatement.setString(5, "0");
            preparedStatement.setString(6, "0");
            preparedStatement.setString(7, "0");
            preparedStatement.setBoolean(8, false);
            
            preparedStatement.execute();
      
            } else {
                 PreparedStatement preparedStatement = conn.prepareStatement(query);
            preparedStatement.setString(1, s[2]);
            preparedStatement.setString(2, s[0]);
            preparedStatement.setString(3, s[1]);
            preparedStatement.setString(4, s[3]);
            preparedStatement.setString(5, s[4]);
            preparedStatement.setString(6, s[5]);
            preparedStatement.setString(7, s[6]);
            preparedStatement.setBoolean(8, true);
            
            preparedStatement.execute();
            
           // System.out.println(Arrays.toString(strings));
            } 
            }
            }
            
            conn.close();
        }
        catch(Exception ex){
            System.err.println("Erro a enviar dados ao servidor!");
            System.err.println(ex.getMessage());
            //System.out.println("Exception: " + ex.toString());
           // ex.printStackTrace(System.out);
        }
        
    }
    
}


