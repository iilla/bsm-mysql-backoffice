# Backoffice for SQL and data Management 

## 🌟 Project Overview

<p>
  Basic database consulting tool for mysql databases, with some filter options and data extraction to excel sheet files. Easy to use and configure. This project aims to help to manage a MySQL database      for users who are unfamiliar with those technologies. It outputs simple queries by using a form to select the preferred field and the precision of the search. It is also capable of exporting the output in a simple xml excel sheet. 

  The configuration file can be prepared for data filtering (such as the output of just a selection of tables, if we are willing to hide any data to the end user) and the display of different table output size, with more or less fields. 
</p>

### ⭐ Features

<p>
  This is a listing of the main features.
</p>

| Feature       | Description                
|---------------|----------------------------------------------------------------------|
| Database configuration  | Selection of the database to be displayed on the screen. | 
| Excel export  | Button for the exportation of the filtered output to a xml sheet. | 
| Login screen  | Enables or disables login, and user configuration.  |
| Pagination    | Pagination configuration for more or less results.  |
| Output filter | Table field selector for output filter. |
| Table filter  | Shows or hides the preferred tables. |

## 🛠️ Technologies Used

<p>
  The core of the application is made on <b>PHP 8.1</b>, displaying a dinamically generated <b>HTML</b> table based on the user input. It also uses few <b>javascript</b> scripts, based on <b>jQuery 1.9.1</b> for some of the small visual effects, such as floating boxes for long texts inside the table cells, pagination and displaying variable type of the selected fields to be filtered.        
</p>

##  🚀 Usage

<p>
  The main index file is set inside the <b>web</b> folder. The logo can be changed by uploading a png image to the <b>style</b>/<b>img</b> folder named <b>bsm_cabecera.png</b>. All files can be uploaded to the desired domain and start the configuration from the <b>config</b>/<b>bsm_settings.php</b>. Inside the file the following variables can be configured: 
</p>

| Variable       | Description                
|---------------|----------------------------------------------------------------------|
| $DB_SET | hostname, username, password and database name for the database configuration. | 
| $APP_NAME | Application name for the page tittle. | 
| $ADM_* | Set of variables for login purposes. |
| $ENABLE_TAB_FILTER | Enables the filter for the display of the tables. |
| $TAB_FILTER | Table selection to be displayed if filter is enabled. |
| $MAX_REG | Maximum fields to be displayed per page on the table output. |

## 📝 Notes

<p>
  This simple application is a good choice for administrators who want to share some information of a MySQL Database with non-technical users. It's simpliciy of use and configuration makes it an excellent tool for database consulting. It can be a also good example for learning and teaching the basics of a database managed via a PHP based website.  
</p>
