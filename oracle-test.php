    <!-- Test Oracle file for UBC CPSC304
      Created by Jiemin Zhang
      Modified by Simona Radu
      Modified by Jessica Wong (2018-06-22)
      Modified by Jason Hall (23-09-20)
      This file shows the very basics of how to execute PHP commands on Oracle.
      Specifically, it will drop a table, create a table, insert values update
      values, and then query for values
      IF YOU HAVE A TABLE CALLED "demoTable" IT WILL BE DESTROYED

      The script assumes you already have a server set up All OCI commands are
      commands to the Oracle libraries. To get the file to work, you must place it
      somewhere where your Apache server can run it, and you must rename it to have
      a ".php" extension. You must also change the username and password on the
      oci_connect below to be your ORACLE username and password
    -->

    <?php
    // The preceding tag tells the web server to parse the following text as PHP
    // rather than HTML (the default)

    // The following 3 lines allow PHP errors to be displayed along with the page
    // content. Delete or comment out this block when it's no longer needed.
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Set some parameters

    // Database access configuration
    $config["dbuser"] = "ora_annie924";			// change "cwl" to your own CWL
    $config["dbpassword"] = "a70808647";	// change to 'a' + your student number
    $config["dbserver"] = "dbhost.students.cs.ubc.ca:1522/stu";
    $db_conn = NULL;	// login credentials are used in connectToDB()

    $success = true;	// keep track of errors so page redirects only if there are no errors

    $show_debug_alert_messages = False; // show which methods are being triggered (see debugAlertMessage())

    // The next tag tells the web server to stop parsing the text as PHP. Use the
    // pair of tags wherever the content switches to PHP
    connectToDB();

     //Select Drop Down options
     $aidResult = executePlainSQL("SELECT DISTINCT aid FROM Accomplishment_gets");
     $accompNamesResult = executePlainSQL("SELECT DISTINCT accompName FROM Accomplishment_gets");
     $typesResult = executePlainSQL("SELECT DISTINCT type FROM Accomplishment_gets");

    ?>

    <html>

    <head>
        <title>CPSC 304 Project</title>
    </head>

    <body>
        <h2>Reset</h2>
        <p>Reset all data</p>

        <form method="POST" action="oracle-test.php">
            <input type="hidden" id="resetTablesRequest" name="resetTablesRequest">
            <p><input type="submit" value="Reset" name="reset"></p>
        </form>

        <hr />

        <h2>Insert Values</h2>

        <p> Insert new Athlete </p >
             <form method="POST" action="oracle-test.php">
             <input type="hidden" id="insertQueryRequest" name="insertQueryRequest">
                 Athlete Name: <input type="text" name="athleteName" required> <br /><br />
                 Athlete Age: <input type="number" name="athleteAge"> <br /><br />
                 Athlete ID: <input type="number" name="athleteID" required> <br /><br />
                 Team ID: <input type="number" name="teamID" required> <br /><br />
             <input type="submit" value="Insert" name="insertSubmit"></p >
             </form>
		<hr />

            <form method="POST" action="oracle-test.php">
            <input type="submit" name="displayInsertData" value="Display Athletes and Teams">
            </form>

             <?php
                 // Check if the 'displayData' button is clicked and display the data
                 if (isset($_POST['displayInsertData'])) {
                     displayAthletes();
                     displayTeams();
                 }
             ?>

         <hr />


        <h2>Delete</h2>

          <p> Delete the Team ID from the database </p >
               <form method="POST" action="oracle-test.php">
               <input type="hidden" id="deleteQueryRequest" name="deleteQueryRequest">
               Team ID: <input type="text" name="deleteTeamID" required> <br /><br />
               <input type="submit" value="Delete" name="deleteSubmit"></p >
          </form>

          <form method="POST" action="oracle-test.php">
          <input type="submit" name="displayDeleteData" value="Display Athletes and Teams">
          </form>

           <?php
               // Check if the 'displayData' button is clicked and display the data
               if (isset($_POST['displayDeleteData'])) {
                   displayAthletes();
                   displayTeams();
               }
           ?>

        <hr />

        <h2>Update Athlete Information in Athletes_belongsTo</h2>
        <p>Enter the Athlete ID and the new information you wish to update.</p>

        <form method="POST" action="oracle-test.php">
            <input type="hidden" id="updateQueryRequest" name="updateQueryRequest">
            Existing Athlete ID: <input type="text" name="aid" required> <br /><br />
            New Name: <input type="text" name="newName"> <br /><br />
            New Age: <input type="text" name="newAge"> <br /><br />
            New Team ID: <input type="text" name="newTid"> <br /><br />

            <input type="submit" value="Update" name="updateSubmit"></p>
        </form>

        <form method="POST" action="oracle-test.php">
            <input type="submit" name="displayUpdateData" value="Display Athletes and Teams">
        </form>

        <?php
            // Check if the 'displayData' button is clicked and display the data
            if (isset($_POST['displayUpdateData'])) {
                displayAthletes();
                displayTeams();
            }
        ?>

        <hr />



         <h2>Select Athletes' Accompishments</h2>

                <form method="GET" action="oracle-test.php">
                <input type="hidden" id="selectQueryRequest" name="selectQueryRequest">
                     <label for="aid">Athlete ID:</label>

                             <select name="aid" id="aid">

                                 <option value="">Select Athlete ID</option>

                                 <?php
                                 /**
                                   * The following code for implementing a drop-down menu selection is inspired by a solution found on Stack Overflow.
                                   * This implementation uses the concept of dynamically populating a drop-down list from an SQL table.
                                   * The original solution, which served as a reference, can be found at:
                                   * https://stackoverflow.com/questions/55426067/how-to-create-a-drop-down-list-with-php-from-an-sql-table-and-display-a-dynamic
                                   * Adaptations have been made to fit the specific requirements of our project.
                                   */
                                     while ($row = oci_fetch_array($aidResult, OCI_ASSOC)) {
                                         echo "<option value='" . $row['AID'] . "'>" . $row['AID'] . "</option>";
                                     }
                                 ?>

                             </select>
                             <br /><br />

                     <label for="accompName">Accomplishment Name:</label>

                             <select name="operator1">
                                 <option value="">NONE</option>
                                 <option value="AND">AND</option>
                                 <option value="OR">OR</option>
                            </select>

                            <select name="accompName" id="accompName">

                                <option value="">Select Accomplishment</option>

                                <?php
                                    while ($row = oci_fetch_array($accompNamesResult, OCI_ASSOC)) {
                                        echo "<option value='" . $row['ACCOMPNAME'] . "'>" . $row['ACCOMPNAME'] . "</option>";
                                    }
                                ?>

                            </select>
                            <br /><br />

                            <label for="type">Type:</label>

                            <select name="operator2">
                                <option value="">NONE</option>
                                <option value="AND">AND</option>
                                <option value="OR">OR</option>
                            </select>

                            <select name="type" id="type">

                                <option value="">Select Type</option>

                                <?php
                                    while ($row = oci_fetch_array($typesResult, OCI_ASSOC)) {
                                        echo "<option value='" . $row['TYPE'] . "'>" . $row['TYPE'] . "</option>";
                                    }
                                ?>

                            </select> <br /><br />

                            <input type="submit" value="Filter" name="selectSubmit"></p>
                </form>

            <form method="POST" action="oracle-test.php">
                        <input type="submit" name="displaySelectData" value="Display Athletes and Accomplishments">
                    </form>

                    <?php
                        // Check if the 'displayData' button is clicked and display the data
                        if (isset($_POST['displaySelectData'])) {
                            displayAthletes();
                            displayAccomplishment_gets();
                        }
                    ?>

          <hr />

              <h2>Projection</h2>
              <p>Select a table from the database and choose attributes to project.</p >
              <form method="POST" action="">
                  <?php listTables(); ?>
              </form>
              <?php
              // Display attributes for selection after a table is chosen
              if (isset($_POST['selectTable'])) {
                  echo "<h3>Selected Table: " . htmlspecialchars($_POST['selectedTable']) . "</h3>";
                  listTableAttributes($_POST['selectedTable']);
              }
              ?>
              <?php
              // Display projected results
              if (isset($_POST['projectAttributes'])) {
                  if (empty($_POST['attributes'])) {
                      echo "No attributes selected.";
                  } else {
                      echo "<h3>Projected Attributes from " . htmlspecialchars($_POST['selectedTable']) . "</h3>";
                      echo "<ul>";
                      foreach ($_POST['attributes'] as $attribute) {
                          echo "<li>" . htmlspecialchars($attribute, ENT_QUOTES, 'UTF-8') . "</li>";
                      }
                      echo "</ul>";
                      displayProjectionResults($_POST['selectedTable'], $_POST['attributes']);
                  }
              }

              ?>


             <hr />

             <h2>Join tables</h2>
			 <p>Join Athletes_belongsTo and Team.</p>
               <form method="GET" action="oracle-test.php">
                <input type="hidden" id="JoinRequest" name="JoinRequest">
				<label for = "Result1"> Choose first display attributes:</label>
				<select name ="Result1" id = "Result1">
					<option value = "Name">Athlete Name</option>
					<option value = "Age">Athlete Age</option>
					<option value = "Country">Athlete Country</option>
					<option value = "Aid">Athlete ID</option>
					<option value = "Tid">Team ID</option>
				
				</select>
             	<br /><br />
				<label for = "Result2"> Choose second display attributes:</label>
				<select name ="Result2" id = "Result2">
					<option value = "Name">Athlete Name</option>
					<option value = "Age">Athlete Age</option>
					<option value = "Country">Athlete Country</option>
					<option value = "Aid">Athlete ID</option>
					<option value = "Tid">Team ID</option>
				</select>
             	<br /><br />

                <label for = "Condition">Condition1:</label>
                <select name = "Condition" id = "Condition">
                <option value = "Name">Athlete Name</option>
					<option value = "Age">Athlete Age</option>
					<option value = "Country">Athlete Country</option>
					<option value = "Aid">Athlete ID</option>
					<option value = "Tid">Team ID</option>
                </select>

				<label for ="Op"> </label>
				<select name="Op" id="Op">
					<option value = "Big">></option>
					<option value = "Less"><</option>
					<option value = "Equal">=</option>
				</select>
				
                Condition2: <input type="text" name="where2" required><br /><br />
                <input type="submit" name="Join"></p >
               </form>

               <form method="POST" action="oracle-test.php">
                        <input type="submit" name="displayJoinData" value="Display Athletes and Teams">
                    </form>

                    <?php
                        // Check if the 'displayData' button is clicked and display the data
                        if (isset($_POST['displayJoinData'])) {
                            displayAthletes();
                            displayTeams();
                        }
                    ?>

            <hr />


             <h2>Group By Tickets' Price</h2>

             <form method="GET" action="oracle-test.php">
             <input type="hidden" id="groupbyQueryRequest" name="groupbyQueryRequest">

             <label for = "ticketAttributes"> Choose an option to filter:</label>
             <select name = "ticketAttributes" id="ticketAttributes">
                <option value ="ticketName">Ticket Name</option>
                <option value ="t#">Ticket Number</option>
                <option value ="CP_year">Competition Year</option>
                <option value ="CP_name">Competition Name</option>
             </select>
             <br /><br />

             <label for = "aggregateFunction"> Choose condition to filter:</label>
             <select name = "aggregateFunction" id="aggregateFunction">
                <option value ="MAX">Maximum Price</option>
                <option value ="MIN">Minimum Price</option>
                <option value ="AVG">Average Price</option>
                <option value ="COUNT">Total Number Tickets</option>
             </select>
             <br /><br />

             <input type="submit" value="Filter" name="GroupBySubmit">
             </form>

			 <form method="POST" action="oracle-test.php">
                 <input type="submit" name="displayGroupByData" value="Display Ticket Information">
             </form>

             <?php
                 // Check if the 'displayData' button is clicked and display the data
                 if (isset($_POST['displayGroupByData'])) {
                     displayTicket_sells2();
                 }
             ?>

			 <hr />

             <h2>Having</h2>
			 <p>Find the number of Athlete over the age 22 for each country with at least 1 athletes.</p>
             <form method = "GET" action="oracle-test.php">
              <input type="hidden" id="havingRequest" name="havingRequest">
              <input type="submit" name="Having">
			 </form>

			 <hr />

			 <h2>Nested</h2>
			 <p>Find the avrage age of athletes for each country who got at least 2 gold</p>
			 <form method="GET" action="oracle-test.php">
			 	<input type="hidden" id="nestedRequest" name="nestedRequest">
              	<input type="submit" name="Nested">
			 </form>

			 <hr />

        <h2>Division</h2>
        <p>Find sponsors who have sponsored competitions for every sport event within the AquaticSports.</p>
        <form method="GET" action="oracle-test.php">
            <input type="hidden" id="divisionRequest" name="divisionRequest">
            <input type="submit" name="divisionSubmit">
        </form>

        <hr />

        <?php
        // The following code will be parsed as PHP

        function debugAlertMessage($message)
        {
            global $show_debug_alert_messages;

            if ($show_debug_alert_messages) {
                echo "<script type='text/javascript'>alert('" . $message . "');</script>";
            }
        }

        function executePlainSQL($cmdstr)
        { //takes a plain (no bound variables) SQL command and executes it
            //echo "<br>running ".$cmdstr."<br>";
            global $db_conn, $success;

            $statement = oci_parse($db_conn, $cmdstr);
            //There are a set of comments at the end of the file that describe some of the OCI specific functions and how they work

            if (!$statement) {
                echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($db_conn); // For oci_parse errors pass the connection handle
                echo htmlentities($e['message']);
                $success = False;
            }

            $r = oci_execute($statement, OCI_DEFAULT);
            if (!$r) {
                echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                $e = oci_error($statement); // For oci_execute errors pass the statementhandle
                echo htmlentities($e['message']);
                $success = False;
            }

            return $statement;
        }

        function executeBoundSQL($cmdstr, $list)
        {
            /* Sometimes the same statement will be executed several times with different values for the variables involved in the query.
            In this case you don't need to create the statement several times. Bound variables cause a statement to only be
            parsed once and you can reuse the statement. This is also very useful in protecting against SQL injection.
            See the sample code below for how this function is used */

            global $db_conn, $success;
            $statement = oci_parse($db_conn, $cmdstr);

            if (!$statement) {
                echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($db_conn);
                echo htmlentities($e['message']);
                $success = False;
            }

            foreach ($list as $tuple) {
                foreach ($tuple as $bind => $val) {
                    //echo $val;
                    //echo "<br>".$bind."<br>";
                    oci_bind_by_name($statement, $bind, $val);
                    unset($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype
                }

                $r = oci_execute($statement, OCI_DEFAULT);
                if (!$r) {
                    echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                    $e = OCI_Error($statement); // For oci_execute errors, pass the statementhandle
                    echo htmlentities($e['message']);
                    echo "<br>";
                    $success = False;
                }
            }
        }

        function printResult($result)
        { //prints results from a select statement
            echo "<br>Retrieved data from table demoTable:<br>";
            echo "<table>";
            echo "<tr><th>ID</th><th>Name</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
                echo "<tr><td>" . $row["ID"] . "</td><td>" . $row["NAME"] . "</td></tr>"; //or just use "echo $row[0]"
            }

            echo "</table>";
        }

        function connectToDB()
        {
            global $db_conn;
            global $config;

            // Your username is ora_(CWL_ID) and the password is a(student number). For example,
            // ora_platypus is the username and a12345678 is the password.
            // $db_conn = oci_connect("ora_cwl", "a12345678", "dbhost.students.cs.ubc.ca:1522/stu");
            $db_conn = oci_connect($config["dbuser"], $config["dbpassword"], $config["dbserver"]);

            if ($db_conn) {
                debugAlertMessage("Database is Connected");
                return true;
            } else {
                debugAlertMessage("Cannot connect to Database");
                $e = OCI_Error(); // For oci_connect errors pass no handle
                echo htmlentities($e['message']);
                return false;
            }
        }

        function disconnectFromDB()
        {
            global $db_conn;

            debugAlertMessage("Disconnect from Database");
            oci_close($db_conn);
        }

        function handleUpdateRequest()
        {
            global $db_conn;

                $aid = filter_var($_POST['aid'], FILTER_VALIDATE_INT);
                $new_name = preg_replace("/[^a-zA-Z\s]/", "", $_POST['newName']);
                $new_age = filter_var($_POST['newAge'], FILTER_VALIDATE_INT);
                $new_tid = filter_var($_POST['newTid'], FILTER_VALIDATE_INT);

                if($aid == false || $new_age == false || $new_tid == false){
                    echo "Invalid input";
                    return;
                }

                $updates = [];

                if(!empty($aid)){
                //Check if the aid exists
                $aidCheck =  executePlainSQL("SELECT aid FROM Athletes_belongsTo WHERE aid=" . $aid);
                    if (!oci_fetch_array($aidCheck)){
                         echo "Error: Athlete with ID " . $aid . " does not exist.";
                         return;
                    }

                }

                if (!empty($new_name)) {
                    $updates[] = "name='" . $new_name . "'";
                }
                if (!empty($new_age)) {
                    $updates[] = "age=" . $new_age;
                }
                if (!empty($new_tid)) {
                    // Check if the new team ID exists
                    $teamCheck = executePlainSQL("SELECT tid FROM Team WHERE tid=" . $new_tid);
                    if ($row = oci_fetch_array($teamCheck)) {
                        $updates[] = "tid=" . $new_tid;
                    } else {
                        echo "Error: Team with ID " . $new_tid . " does not exist.";
                        return;
                    }
                }

                if (!empty($updates)) {
                    $updateQuery = "UPDATE Athletes_belongsTo SET " . implode(', ', $updates) . " WHERE aid=" . $aid;
                    executePlainSQL($updateQuery);
                    oci_commit($db_conn);
                    echo "Athlete information updated successfully.";

                    displayAthletes();
                } else {
                    echo "No updates provided.";
                }

        }

        function displayAthletes()
        {
            global $db_conn;

            $result = executePlainSQL("SELECT * FROM Athletes_belongsTo");
            echo "<br>Athletes Data:<br>";
            echo "<table border='1'>";
            echo "<tr><th>Athlete ID</th><th>Name</th><th>Age</th><th>Team ID</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
                echo "<tr><td>" . $row["AID"] . "</td><td>" . $row["NAME"] . "</td><td>" . $row["AGE"] . "</td><td>" . $row["TID"] . "</td></tr>";
            }

            echo "</table>";
        }

        function displayTeams()
        {
            global $db_conn;

            $result = executePlainSQL("SELECT * FROM Team");
            echo "<br>Team Data:<br>";
            echo "<table border='1'>";
            echo "<tr><th>Team ID</th><th>Country</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
                echo "<tr><td>" . $row["TID"] . "</td><td>" . $row["COUNTRY"] . "</td></tr>";
            }

            echo "</table>";
        }

        function displayAccomplishment_gets()
        {
            global $db_conn;

            $result = executePlainSQL("SELECT * FROM Accomplishment_gets");
            echo "<br>Accomplishment Data:<br>";
            echo "<table border='1'>";
            echo "<tr><th>Athlete ID</th><th>Accomplishments' Name</th><th>Type</th><th>";

            while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
                echo "<tr><td>" . $row["AID"] . "</td><td>" . $row["ACCOMPNAME"] . "</td><td>" . $row["TYPE"] . "</td><tr>";
            }

            echo "</table>";
        }

        function displayTicket_sells2()
        {
            global $db_conn;

            $result = executePlainSQL("SELECT * FROM Tickets_sells2");
            echo "<br>Tickets' Information:<br>";
            echo "<table border='1'>";
            echo "<tr><th>Ticket Name</th><th>Ticket Number</th><th>Competition Year</th><th>Competition Name</th><th>Price</th><tr>";

            while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
                echo "<tr><td>" . $row["TICKETNAME"] . "</td><td>" . $row["T#"] . "</td><td>" . $row["CP_YEAR"] . "</td><td>" . $row["CP_NAME"] . "</td><td>" . $row["PRICE"] . "</td><tr>";
            }

            echo "</table>";
        }


        function executeSQLScript($filePath) {
            global $db_conn;

            $scriptContent = file_get_contents($filePath);
            $sqlCommands = explode(';', $scriptContent); // assuming each SQL command ends with a semicolon

            foreach ($sqlCommands as $command) {
                if (trim($command)) {
                    executePlainSQL($command);
                }
            }
        }

        function handleResetRequest()
        {
            global $db_conn;

            // Drop old table
            executePlainSQL("DROP TABLE Accomplishment_gets CASCADE CONSTRAINTS");
            executePlainSQL("DROP TABLE Plays CASCADE CONSTRAINTS");
            executePlainSQL("DROP TABLE Coach_Teaches CASCADE CONSTRAINTS");
            executePlainSQL("DROP TABLE Athletes_belongsTo CASCADE CONSTRAINTS");
            executePlainSQL("DROP TABLE SoldOn CASCADE CONSTRAINTS");
            executePlainSQL("DROP TABLE Tickets_sells2 CASCADE CONSTRAINTS");
            executePlainSQL("DROP TABLE Holds CASCADE CONSTRAINTS");
            executePlainSQL("DROP TABLE Sponsor2 CASCADE CONSTRAINTS");
            executePlainSQL("DROP TABLE Sponsor1 CASCADE CONSTRAINTS");
            executePlainSQL("DROP TABLE Has CASCADE CONSTRAINTS");
            executePlainSQL("DROP TABLE Platform CASCADE CONSTRAINTS");
            executePlainSQL("DROP TABLE AquaticSports CASCADE CONSTRAINTS");
            executePlainSQL("DROP TABLE SnowSports CASCADE CONSTRAINTS");
            executePlainSQL("DROP TABLE BallGames CASCADE CONSTRAINTS");
            executePlainSQL("DROP TABLE Sports CASCADE CONSTRAINTS");
            executePlainSQL("DROP TABLE Competition CASCADE CONSTRAINTS");
            executePlainSQL("DROP TABLE Team CASCADE CONSTRAINTS");

            // Create new table
            echo "<br> creating new table <br>";
            executeSQLScript('/home/a/annie924/public_html/script.sql');

            oci_commit($db_conn);
        }

         function handleInsertRequest()
          {
               global $db_conn;

               //Getting the values from user and insert data into the table


               $tuple = array(
                ":Athlete_Name" => preg_replace("/[^a-zA-Z\s]/", "", $_POST['athleteName']),
                ":Athlete_Age" => filter_var($_POST['athleteAge'], FILTER_VALIDATE_INT ),
                ":Athlete_ID" => filter_var($_POST['athleteID'], FILTER_VALIDATE_INT ),
                ":Team_ID" => filter_var($_POST['teamID'], FILTER_VALIDATE_INT ),
               );

               if(filter_var($_POST['athleteAge'], FILTER_VALIDATE_INT ) == false
                  || filter_var($_POST['athleteID'], FILTER_VALIDATE_INT ) == false
                  || filter_var($_POST['teamID'], FILTER_VALIDATE_INT ) == false){
                    echo "Invalid input";
                    return;
                  }
				
               $TeamID = $_POST['teamID'];
               $AID = $_POST['athleteID'];
			   $Age = $_POST['athleteAge'];
               $athleteName = $_POST['athleteName'];

			   if (empty($athleteName)) {
        		echo "Invalid Athlete Name";
        		return;
    			}

			   if ($AID <= 0) {
				echo "Invalid ID";
				return;
			   }

			   if ($Age <= 0) {
				echo "Invalid Age";
				return;
			   }

               $alltuples = array($tuple);


               $teamCheckResult = executePlainSQL("SELECT tid FROM Team WHERE tid =" . $TeamID);

               if (!oci_fetch_array($teamCheckResult)) {
                    echo "Error: Team with ID " . $TeamID . " does not exist.";
                    return;
               }

               $athleteCheck = executePlainSQL("SELECT aid FROM Athletes_belongsTo WHERE aid=" . $AID);

               if(oci_fetch_array($athleteCheck)) {
                   echo "Error: Athlete with ID " . $AID . " already exists.";
                   return;
               }
               executeBoundSQL("INSERT INTO Athletes_belongsTo(name,age,aid,tid) VALUES (:Athlete_Name, :Athlete_Age, :Athlete_ID, :Team_ID)", $alltuples);
               oci_commit($db_conn);


                echo "Athlete Added Successfull!";
                $result = executePlainSQL("SELECT * FROM Athletes_belongsTo");
                displayAthletes();

          }

         function handleDeleteRequest()
          {
               global $db_conn;

               $tuple = array(
                ":teamID" => filter_var($_POST['deleteTeamID'], FILTER_VALIDATE_INT )
               );

               if(filter_var($_POST['deleteTeamID'], FILTER_VALIDATE_INT ) == false){
                    echo "Invalid input";
                    return;
               }

               $alltuples = array(
                $tuple
               );

               echo "<br> Table before delete Team ID: </br>";
               displayTeams();

               executeBoundSQL("DELETE FROM Team WHERE tid = :teamID", $alltuples);

               echo "<br> Table after delete Team ID: </br>";
               displayTeams();
               oci_commit($db_conn);

          }

          /**
           * The implementation of joining array elements to form a SQL query string
           * utilizes the `implode` function in PHP. This approach was adapted from
           * a Stack Overflow discussion which provides insights on using `implode`
           * for adding values before and after array elements.
           * The original discussion can be found at:
           * https://stackoverflow.com/questions/51357806/php-how-do-i-join-array-elements-adding-values-before-and-after-using-implode
           * This technique has been integrated to construct SQL queries dynamically in our application.
           */
          function handleSelectRequest() {
              global $db_conn;

                  $aid = $_GET['aid'];
                  $accompName = $_GET['accompName'];
                  $type = $_GET['type'];
                  $operator1 = $_GET['operator1'];
                  $operator2 = $_GET['operator2'];

                  $query = "SELECT * FROM Accomplishment_gets WHERE ";

                  $conditions = [];
                  if (!empty($aid)) {
                      $conditions[] = "aid = '" . $aid . "'";
                  }
                  if (!empty($accompName)) {
                      $conditions[] = " $operator1 accompName = '" . $accompName . "'";
                  }
                  if (!empty($type)) {
                      $conditions[] = " $operator2 type = '" . $type . "'";
                  }

                  // Combine all conditions
                  $query .= implode(" ", $conditions);

                  // Execute query and display results
                  $result = executePlainSQL($query);
                  printSelectResults($result);

          }

          function printSelectResults($result) {
              echo "<br>Results:<br>";
              echo "<table border='1'>";
              echo "<tr><th>Athlete ID</th><th>Accomplishment Name</th><th>Type</th></tr>";

              while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
                  echo "<tr><td>" . $row["AID"] . "</td><td>" . $row["ACCOMPNAME"] . "</td><td>" . $row["TYPE"] . "</td></tr>";
              }

              echo "</table>";
          }

          function handleProjectSelectedAttributes($relationName, $attributes) {
              global $db_conn;

              $sanitizedAttributes = array_map(function($attr) {
                  return htmlspecialchars($attr, ENT_QUOTES, 'UTF-8');
              }, $attributes);

              $selectedAttributes = implode(", ", $sanitizedAttributes);
              $query = "SELECT $selectedAttributes FROM " . htmlspecialchars($relationName, ENT_QUOTES, 'UTF-8');

              $result = executePlainSQL($query);

              echo "<table border='1'>";
              echo "<tr>";
              foreach ($sanitizedAttributes as $attr) {
                  echo "<th>" . $attr . "</th>";
              }
              echo "</tr>";

              while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
                  echo "<tr>";
                  foreach ($sanitizedAttributes as $attr) {
                      echo "<td>" . $row[$attr] . "</td>";
                  }
                  echo "</tr>";
              }
              echo "</table>";
              oci_commit($db_conn);
          }


          function listTables() {
              global $db_conn;
              $result = executePlainSQL("SELECT table_name FROM USER_TABLES");
              echo "<form method='POST' action=''>";
              echo "Choose a table: <select name='selectedTable'>";
              echo "<option value='' disabled selected>Select a table</option>"; // Placeholder option
              while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                  $isSelected = (isset($_POST['selectedTable']) && $_POST['selectedTable'] == $row["TABLE_NAME"]) ? ' selected' : '';
                  echo "<option value='" . htmlspecialchars($row["TABLE_NAME"], ENT_QUOTES, 'UTF-8') . "'" . $isSelected . ">" . htmlspecialchars($row["TABLE_NAME"], ENT_QUOTES, 'UTF-8') . "</option>";
              }
              echo "</select>";
              echo "<input type='submit' value='Select' name='selectTable'>";
              echo "</form>";
          }


          function listTableAttributes($tableName) {
              global $db_conn;
              $result = executePlainSQL("SELECT column_name FROM USER_TAB_COLUMNS WHERE table_name = '$tableName'");
              echo "<form method='POST' action=''>";
              echo "<input type='hidden' name='selectedTable' value='" . htmlspecialchars($tableName, ENT_QUOTES, 'UTF-8') . "'>";
              echo "Select attributes: <br>";
              while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                  echo "<input type='checkbox' name='attributes[]' value='" . htmlspecialchars($row["COLUMN_NAME"], ENT_QUOTES, 'UTF-8') . "'>" . htmlspecialchars($row["COLUMN_NAME"], ENT_QUOTES, 'UTF-8') . "<br>";
              }
              echo "<input type='submit' value='Project' name='projectAttributes'>";
              echo "</form>";
          }

          function displayProjectionResults($tableName, $attributes) {
          global $db_conn;

          $sanitizedAttributes = array_map(function($attr) {
              return htmlspecialchars($attr, ENT_QUOTES, 'UTF-8');
          }, $attributes);

          if (empty($sanitizedAttributes)) {
              echo "No attributes selected.";
              return;
          }
          $selectedAttributes = implode(", ", $sanitizedAttributes);
          $query = "SELECT $selectedAttributes FROM " . strtoupper(htmlspecialchars($tableName, ENT_QUOTES, 'UTF-8'));

          $result = executePlainSQL($query);
          if (!$result) {
              echo "<br>Error in executing the SQL query.<br>";
              return;
          }

          echo "<h3>Projection Results from " . htmlspecialchars($tableName, ENT_QUOTES, 'UTF-8') . "</h3>";
          echo "<table border='1'>";
          echo "<tr>";
          foreach ($sanitizedAttributes as $attr) {
              echo "<th>" . $attr . "</th>";
          }
          echo "</tr>";

          while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
              echo "<tr>";
              foreach ($sanitizedAttributes as $attr) {
                  echo "<td>" . $row[$attr] . "</td>";
              }
              echo "</tr>";
          }
          echo "</table>";
      }

      function handleJoinRequest() 
	  {
         global $db_conn;
		 $tuple = array(
		 $condition1 = $_GET['Condition'],
		 $condition2 = $_GET['where2'],
         );


        $select1 = $_GET['Result1'];
		$select2 = $_GET['Result2'];
		$connect = $_GET['Op'];

		$sql = "SELECT $select1,$select2 FROM Athletes_belongsTo A, Team T WHERE A.tid = T.tid AND ";
		switch ($connect) {
			case 'Big':
				$result = executePlainSQL($sql .= "$condition1 > '$condition2'");
				break;
			case 'Less':
				$result = executePlainSQL($sql .= "$condition1 < '$condition2'");
				break;
			case 'Equal':
				$result = executePlainSQL($sql .= "$condition1 = '$condition2'");
				break;
			default:
				// Handle any other operators or default case if needed
				break;
		}

         echo "<br> Join Result: </br>";
         echo "<table border='1'>";
         echo "<tr><th>$select1</th><th>$select2</th></tr>";

           while ($row = oci_fetch_array($result, OCI_ASSOC)) {
            echo "<tr><td>" . $row[strtoupper($select1)] . "</td><td>" . $row[strtoupper($select2)] . "</td></tr>";
           }

           echo "</table>";

                  oci_commit($db_conn);
        }

        function handleGroupByRequest(){
            global $db_conn;

            $ticketAttributes = $_GET['ticketAttributes'];
            $aggregateFunction = $_GET['aggregateFunction'];

            $result = executePlainSQL("SELECT $ticketAttributes, ROUND($aggregateFunction(Price), 2) AS AggregateResult FROM Tickets_sells2 GROUP BY $ticketAttributes");

            echo "<br>Group By Results:<br>";
            echo "<table border='1'>";
            echo "<tr><th>$ticketAttributes</th><th>$aggregateFunction</th></tr>";

            // Fetch and display each row
            while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
                echo "<tr><td>" . $row[strtoupper($ticketAttributes)] . "</td><td>" . $row["AGGREGATERESULT"] . "</td></tr>";
            }

            echo "</table>";

        }

        function handleHavingRequest()
        {
            global $db_conn;

            $query = "SELECT Country,Count(*) AS AthleteCount FROM Athletes_belongsTo A, Team T WHERE age > 22 AND A.tid = T.tid
					  GROUP BY Country HAVING Count(*) >= 1";
            $result = executePlainSQL($query);

            echo "<br>Having result:<br>";
            echo "<table border='1'>";
            echo "<tr><th>Country</th><th>AthleteCount</th></tr>";
            
            while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
                echo "<tr><td>" . $row["COUNTRY"] . "</td><td>" . $row["ATHLETECOUNT"] . "</td></tr>";
            }
            echo "</table>";

            oci_commit($db_conn);
        }

		function handleNestedRequest()
		{
			global $db_conn;

			$query = "SELECT T.country, AVG(A.age) AS Average_age
			FROM Athletes_belongsTo A, Team T
			WHERE A.tid = T.tid
			AND A.aid IN (
				SELECT AG.aid
				FROM Accomplishment_gets AG
				WHERE AG.type = 'Gold'
				GROUP BY AG.aid
				HAVING COUNT(*) >= 2
			)
			GROUP BY T.country";

			$result = executePlainSQL($query);


            echo "<br>Nested result:<br>";
            echo "<table border='1'>";
            echo "<tr><th>Country</th><th>Average_age</th></tr>";
            while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
                echo "<tr><td>" . $row["COUNTRY"] . "</td><td>" . $row["AVERAGE_AGE"] . "</td></tr>";
            }
            echo "</table>";

            oci_commit($db_conn);
		}


        function handleDivisionRequest()
        {
            global $db_conn;

            $query = "SELECT s2.SponsorName
			  FROM Sponsor2 s2
			  WHERE NOT EXISTS (
					(
						SELECT a.S_name
						FROM AquaticSports a
					) 
					MINUS (
						SELECT a2.S_name
						FROM AquaticSports a2, Has h, Holds ho
						WHERE a2.S_name = h.S_name 
						    AND h.CP_name = ho.CP_name
						    AND h.CP_year = ho.CP_year 
						    AND ho.SponsorName = s2.SponsorName
					)
				)";
            $result = executePlainSQL($query);

            if (!$result) {
                // Error in execution
                $e = oci_error();
                echo "There was an error running the query: " . $e['message'];
                return;
            }

            echo "<br>Division result:<br>";
            echo "<table border='1'>";
            echo "<tr><th>Sponsor Name</th></tr>";
            // Fetch and display each row
            while ($row = OCI_Fetch_Array($result, OCI_ASSOC)) {
                echo "<tr><td>" . $row["SPONSORNAME"] . "</td></tr>";
            }
            echo "</table>";

            oci_commit($db_conn);
        }

        // HANDLE ALL POST ROUTES
        // A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
        function handlePOSTRequest()
        {
            if (connectToDB()) {
                if (array_key_exists('resetTablesRequest', $_POST)) {
                    handleResetRequest();
                } else if (array_key_exists('updateQueryRequest', $_POST)) {
                    handleUpdateRequest();
                } else if (array_key_exists('insertQueryRequest', $_POST)) {
                    handleInsertRequest();
                } else if (array_key_exists('deleteQueryRequest', $_POST)) {
                    handleDeleteRequest();
                }
                else if (array_key_exists('projectAttributes', $_POST)) {
                    handleProjectSelectedAttributes($_POST['selectedTable'], $_POST['attributes']);
                }

                disconnectFromDB();
            }
        }

        // HANDLE ALL GET ROUTES
        // A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
        function handleGETRequest()
        {
            if (connectToDB()) {
                if (array_key_exists('selectSubmit', $_GET)) {
                    handleSelectRequest();
                } else if (array_key_exists('Join', $_GET)) {
                   handleJoinRequest();
               } else if (array_key_exists('GroupBySubmit', $_GET)) {
                   handleGroupByRequest();
               } else if (array_key_exists('divisionSubmit', $_GET)) {
                   handleDivisionRequest();
               } else if (array_key_exists('Having',$_GET)) {
                handleHavingRequest();
               } else if (array_key_exists('Nested',$_GET)) {
                handleNestedRequest();
               }

                disconnectFromDB();
            }
        }

        if (isset($_POST['reset'])
            || isset($_POST['updateSubmit'])
            || isset($_POST['insertSubmit'])
            || isset($_POST['deleteSubmit'])) {
            handlePOSTRequest();
        } else if (isset($_GET['selectQueryRequest'])
                   || isset($_GET['JoinRequest'])
                   || isset($_GET['groupbyQueryRequest'])
                   || isset($_GET['divisionRequest'])
                   || isset($_GET['havingRequest'])
				   || isset($_GET['nestedRequest'])) {
            handleGETRequest();
        }

        // End PHP parsing and send the rest of the HTML content
        ?>
    </body>

    </html>
