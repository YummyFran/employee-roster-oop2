<?php

class Main {
    private EmployeeRoster $roster;

    public function main() {
        $this->playIntro();  
        $size = $this->askRosterSize();
        $this->roster = new EmployeeRoster($size);
        $this->mainMenu();
    }

    private function playIntro() {
        $this->clear();

        $art = [
            "░▒▓███████▓▒░ ░▒▓██████▓▒░ ░▒▓███████▓▒░▒▓████████▓▒░▒▓████████▓▒░▒▓███████▓▒░",
            "░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░         ░▒▓█▓▒░   ░▒▓█▓▒░      ░▒▓█▓▒░░▒▓█▓▒░",
            "░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░         ░▒▓█▓▒░   ░▒▓█▓▒░      ░▒▓█▓▒░░▒▓█▓▒░",
            "░▒▓███████▓▒░░▒▓█▓▒░░▒▓█▓▒░░▒▓██████▓▒░   ░▒▓█▓▒░   ░▒▓██████▓▒░ ░▒▓███████▓▒░",
            "░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░░▒▓█▓▒░      ░▒▓█▓▒░  ░▒▓█▓▒░   ░▒▓█▓▒░      ░▒▓█▓▒░░▒▓█▓▒░",
            "░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░░▒▓█▓▒░      ░▒▓█▓▒░  ░▒▓█▓▒░   ░▒▓█▓▒░      ░▒▓█▓▒░░▒▓█▓▒░",
            "░▒▓█▓▒░░▒▓█▓▒░░▒▓██████▓▒░░▒▓███████▓▒░   ░▒▓█▓▒░   ░▒▓████████▓▒░▒▓█▓▒░░▒▓█▓▒░"
        ];

        $this->printText($art);

        readline("\nPress Enter key to continue...");
    }

    private function askRosterSize() {
        $this->clear();
        
        $this->printText($this->generateTextBox("Booting Employee Roster"));
        echo "\n";
        $this->printText("██loading...██████████████████████████", 8);

        $size;
        do {
            $this->clear();
            $this->printText($this->generateTextBox("Please Enter Roster Size"));
    
            $size = (int) readline("> ");

            if($size < 1) {
                $this->printText("Invalid input. Please enter a number greater than 0.");
                usleep(1000000);
            }
        } while($size < 1);

        $this->printText("Creating $size roster slots...");
        usleep(2000000);
        $this->printText("$size slots sucessfully created!");
        usleep(1000000);

        return $size;
    }

    private function displayMainMenu() {
        $choice;
        do {
            $this->clear();
            $this->printText($this->generateTextBox(["Employee Roster Menu", "Slots available: " . ($this->roster->getSize() - $this->roster->count())]));
            $this->printText([
                "[1] Add Employee",
                "[2] Delete Employee",
                "[3] Other Menu",
                "[0] Exit"
            ], 1, 6);
            
            $choice = $this->validateInput("> ");

            if ($choice === "" || trim($choice) == "" || !is_numeric($choice)) {
                $this->printText("Invalid input. Please enter a number between 0 and 3.", 2);
                usleep(1000000);
                continue;
            }

            $choice = (int) $choice;

            if($choice < 0 || $choice > 3) {
                $this->printText("Invalid input. Please enter a number that corresponds to the menu", 2);
                usleep(1000000);
            }
        } while($choice < 0 || $choice > 3);

        return $choice;
    }

    private function mainMenu() {
        $choice = $this->displayMainMenu();

        switch($choice) {
            case 1:
                $this->addEmployee();
                break;
            case 2:
                $this->deleteEmployee();
                break;
            case 3:
                $this->otherMenu();
                break;
            case 0:
                $this->printText("Shutting down...");
                break;
            default:
                $this->printText("Invalid Input.");
                $this->mainMenu();
        }
    }

    private function addEmployee() {
        $this->clear();

        if($this->roster->count() >= $this->roster->getSize()) {
            $this->printText($this->generateTextBox(["I'm sorry,", "All slots are occupied"]));
            usleep(1000000);
            $this->mainMenu();
            return;
        }

        $this->printText($this->generateTextBox(["Add Employee Form", "Please fill up the required details"]));

        echo "\n";
        $name = $this->validateInput("Name: ");
        $address = $this->validateInput("Address: ");
        $company = $this->validateInput("Company Name: ");
        $age = $this->validateInput("Age: ", "integer");

        $choice;
        do{
            $this->printText([
                "Type of Employee",
                "[1] Commisionned Employee",
                "[2] Hourly Employee",
                "[3] Piece Worker"
            ], 1, 11);

            $choice = (int) readline("> ");

            if($choice < 1 || $choice > 3) {
                $this->printText("Invalid input. Please enter a number that corresponds to the type of employee", 2);
                usleep(1000000);
            }

        } while($choice < 1 || $choice > 3);


        switch($choice) {
            case 1:
                $this->addCommissionedEmployee($name, $address, $company, $age);
                break;
            case 2:
                $this->addHourlyEmployee($name, $address, $company, $age);
                break;
            case 3:
                $this->addPieceWorker($name, $address, $company, $age);
                break;
        }

        if($this->roster->count() >= $this->roster->getSize()) {
            $this->clear();
            $this->printText($this->generateTextBox(["Warning!", "All slots are occupied"]));
            usleep(1000000);
            $this->mainMenu();
            return;
        }

        if(strtolower(readline("Add more? (y to continue): ")) =='y') 
            $this->addEmployee();
        else 
            $this->mainMenu();
    }

    private function addCommissionedEmployee($name, $address, $company, $age) {
        $regularSalary = $this->validateInput("Regular salary: ", "float");
        $itemsSold = $this->validateInput("Number of sold items: ", "integer");
        $commissionRate = $this->validateInput("Commission rate per item: ", "integer");

        $employee = new CommissionEmployee($regularSalary, $itemsSold, $commissionRate, $name, $address, $age, $company);

        $this->roster->add($employee) && $this->printText("Employee added successfully\n", 1);
    }

    private function addHourlyEmployee($name, $address, $company, $age) {
        $hoursWorked = $this->validateInput("Hours worked: ", "integer");
        $hourlyRate = $this->validateInput("Hourly Rate: ", "integer");

        $employee = new HourlyEmployee($hoursWorked, $hourlyRate, $name, $address, $age, $company);

        $this->roster->add($employee) && $this->printText("Employee added successfully\n", 1);
    }

    private function addPieceWorker($name, $address, $company, $age) {
        $itemsProduced = $this->validateInput("Number of items produced: ", "integer");
        $wagePerItem = $this->validateInput("Wage per item: ", "integer");

        $employee = new PieceWorker($itemsProduced, $wagePerItem, $name, $address, $age, $company);
        $this->roster->add($employee) && $this->printText("Employee added successfully\n", 1);
    }
    
    private function deleteEmployee() {
        $this->clear();
        $this->printText($this->generateTextBox("Delete Employee"));
        $employees = $this->roster->display();
        $this->displayEmployees($employees, true);
        
        if(count($employees) == 0) {
            readline("Press Enter to Continue...");
            $this->mainMenu();
            return;
        }

        $this->printList($this->generateTextBox(["Enter Employee Number to Delete", "[0] Return"]));
        $index = (int) readline("> ");

        if($index == 0) {
            $this->mainMenu();
            return;
        }

        $this->clear();
        $this->roster->remove($index - 1) ?
        $this->printText($this->generateTextBox("Employee deleted successfully"), 1) :
        $this->printText($this->generateTextBox("Employee not found"), 1);

        sleep(1);
        $this->deleteEmployee();

    }

    private function otherMenu() {
        $choice;
        do {
            $this->clear();
            $this->printText($this->generateTextBox(["Accessibilitty Menu"]));
            $this->printText([
                "[1] Display",
                "[2] Count",
                "[3] Payroll",
                "[0] Return"
            ], 1, 5);
            
            $choice = $this->validateInput("> ");

            if ($choice === "" || trim($choice) == "" || !is_numeric($choice)) {
                $this->printText("Invalid input. Please enter a number between 0 and 3.", 2);
                usleep(1000000);
                continue;
            }
            
            $choice = (int) $choice;

            if($choice < 0 || $choice > 3) {
                $this->printText("Invalid input. Please enter a number that corresponds to the menu", 2);
                usleep(1000000);
            }
        } while($choice < 0 || $choice > 3);

        switch($choice) {
            case 1:
                $this->displayMenu();
                break;
            case 2:
                $this->countMenu();
                break;
            case 3:
                $this->payroll();
                break;
            case 0:
                $this->mainMenu();
                break;
            default:
                $this->printText("Invalid Input.");
                $this->otherMenu();
        }
    }

    private function displayMenu() {
        $choice;
        do {
            $this->clear();
            $this->printText($this->generateTextBox("Display Employees"));
            $this->printText([
                "[1] Display All Employees",
                "[2] Display Commissioned Employees",
                "[3] Display Hourly Employees",
                "[4] Display Piece Workers",
                "[0] Return"
            ], 1, 5);

            $choice = $this->validateInput("> ");

            if ($choice === "" || trim($choice) == "" || !is_numeric($choice)) {
                $this->printText("Invalid input. Please enter a number between 0 and 4.", 2);
                usleep(1000000);
                continue;
            }
            
            $choice = (int) $choice;

            if($choice < 0 || $choice > 4) {
                $this->printText("Invalid input. Please enter a number that corresponds to the menu", 2);
                usleep(1000000);
            }
        } while($choice < 0 || $choice > 4);

        switch($choice) {
            case 1:
                $this->displayAllEmployees();
                break;
            case 2:
                $this->displayCommissionedEmployees();
                break;
            case 3:
                $this->displayHourlyEmployees();
                break;
            case 4:
                $this->displayPieceWorkers();
                break;
            case 0:
                $this->otherMenu();
                break;
        }
    }

    private function displayAllEmployees() {
        $this->clear();
        $this->printText($this->generateTextBox("All Employees"));
        $employees = $this->roster->display();

        $this->displayEmployees($employees, true);

        readline("Press Enter to Continue...");
        $this->displayMenu();
    }

    private function displayCommissionedEmployees() {
        $this->clear();
        $this->printText($this->generateTextBox("Commissioned Employees"));
        $employees = $this->roster->displayCE();

        $this->displayEmployees($employees);

        readline("Press Enter to Continue...");
        $this->displayMenu();
    }

    function displayHourlyEmployees() {
        $this->clear();
        $this->printText($this->generateTextBox("Hourly Employees"));
        $employees = $this->roster->displayHE();

        $this->displayEmployees($employees);

        readline("Press Enter to Continue...");
        $this->displayMenu();
    }

    function displayPieceWorkers() {
        $this->clear();
        $this->printText($this->generateTextBox("Piece Workers"));
        $employees = $this->roster->displayPW();

        $this->displayEmployees($employees);

        readline("Press Enter to Continue...");
        $this->displayMenu();
    }

    private function displayEmployees($employees, $all = false) {
        if(count($employees) == 0) {
            $this->printText($this->generateTextBox("No Employees Found"), 1, 5);
            return;
        }

        for($i = 0; $i < count($employees); $i++) {
            $employee = $employees[$i];
            $card = [];

            if($all)    array_push($card, "Employee #" . ($employee[5] + 1));   
            else        array_push($card, $i + 1 . ".");

            array_push($card, "Name: $employee[0]");
            array_push($card, "Address: $employee[1]");
            array_push($card, "Age: $employee[2]");
            array_push($card, "Company Name: $employee[3]");
            array_push($card, "Type: $employee[4]");

            $this->printList($this->generateLeftAlignedTextBox($card));
        }
    }

    private function countMenu() {
        $choice;
        do {
            $this->clear();
            $this->printText($this->generateTextBox("Count Employees"));
            $this->printText([
                "[1] Count All Employees",
                "[2] Count Commissioned Employees",
                "[3] Count Hourly Employees",
                "[4] Count Piece Workers",
                "[0] Return"
            ], 1, 5);

            $choice = $this->validateInput("> ");

            if ($choice === "" || trim($choice) == "" || !is_numeric($choice)) {
                $this->printText("Invalid input. Please enter a number between 0 and 4.", 2);
                usleep(1000000);
                continue;
            }
            
            $choice = (int) $choice;

            if($choice < 0 || $choice > 4) {
                $this->printText("Invalid input. Please enter a number that corresponds to the menu", 2);
                usleep(1000000);
            }
        } while($choice < 0 || $choice > 4);

        switch($choice) {
            case 1:
                $this->countAllEmployees();
                break;
            case 2:
                $this->countCommissionedEmployees();
                break;
            case 3:
                $this->countHourlyEmployees();
                break;
            case 4:
                $this->countPieceWorkers();
                break;
            case 0:
                $this->otherMenu();
                break;
        }
    }
    
    private function countAllEmployees() {
        $this->clear();
        $count = $this->roster->count();
        $max = $this->roster->getSize();
        $this->printText($this->generateTextBox([
            "All Employees Listed",
            "$count out of $max"
        ]));

        readline("Press Enter to Continue...");
        $this->countMenu();
    }

    private function countCommissionedEmployees() {
        $this->clear();
        $count = $this->roster->countCE();
        $max = $this->roster->getSize();
        $this->printText($this->generateTextBox([
            "Commissioned Employees Listed",
            "$count out of $max"
        ]));

        readline("Press Enter to Continue...");
        $this->countMenu();
    }
    
    private function countHourlyEmployees() {
        $this->clear();
        $count = $this->roster->countHE();
        $max = $this->roster->getSize();
        $this->printText($this->generateTextBox([
            "Hourly Employees Listed",
            "$count out of $max"
        ]));

        readline("Press Enter to Continue...");
        $this->countMenu();
    }

    private function countPieceWorkers() {
        $this->clear();
        $count = $this->roster->countPW();
        $max = $this->roster->getSize();
        $this->printText($this->generateTextBox([
            "Piece Workers Listed",
            "$count out of $max"
        ]));

        readline("Press Enter to Continue...");
        $this->countMenu();
    }

    private function payroll() {
        $this->clear();
        $this->printText($this->generateTextBox("Pay Roll"));
        $employees = $this->roster->payroll();

        if(count($employees) == 0) {
            $this->printText($this->generateTextBox("No Employees Found"), 1, 5);
            readline("Press Enter to Continue...");
            $this->otherMenu();
            return;
        }

        for($i = 0; $i < count($employees); $i++) {
            $employee = $employees[$i];
            $card = [];

            array_push($card, "Employee #" . ($employee[0] + 1));

            array_push($card, "Name: $employee[1]");
            array_push($card, "Address: $employee[2]");
            array_push($card, "Age: $employee[3]");
            array_push($card, "Company Name: $employee[4]");

            if($employee[5] == "Commissioned Employee") {
                array_push($card, "Regular Salary: $employee[7]"); 
                array_push($card, "Items Sold: $employee[8]"); 
                array_push($card, "Commission Rate: $employee[9]"); 
            }

            if($employee[5] == "Hourly Employee") {
                array_push($card, "Hours Worked: $employee[7]");    
                array_push($card, "Hourly Rate: $employee[8]");
            }

            if($employee[5] == "Piece Worker") {
                array_push($card, "Items Produced: $employee[7]");    
                array_push($card, "Wage Per Item: $employee[8]");
            }

            array_push($card, "Earnings: $employee[6]");

            $this->printList($this->generateLeftAlignedTextBox($card));
        }

        readline("Press Enter to Continue...");
        $this->otherMenu();
    }

    private function generateLeftAlignedTextBox($texts) {
        if(gettype($texts) == "string") {
            $texts = [$texts];
        }

        $box = [];
        $maxTextSize = max(array_map('strlen', $texts));
        $padding = 2;

        for($i = 0; $i < count($texts) + 3; $i++) {
            $current = $i == 0 ? '.' : '|';
            $textSize = $i > 1 && $i < count($texts) + 2 ? strlen($texts[$i - 2]) : $maxTextSize;
            
            for($j = 0; $j < $maxTextSize + ($padding * 2); $j++) {
                $current .= ($i == 0 || $i == 2 + count($texts)) ? '_' :
                (($i == 1 || $j < $padding || $j >= $padding + $textSize) ? ' ' :
                $texts[$i - 2][$j - $padding]);
            }

            $current .= $i == 0 ? ". " : "|";

            array_push($box, $current);
        }

        return $box;
    }

    private function generateTextBox($texts) {
        if(gettype($texts) == "string") {
            $texts = [$texts];
        }

        $box = [];
        $maxTextSize = max(array_map('strlen', $texts));
        $padding = 8;

        for($i = 0; $i < count($texts) + 3; $i++) {
            $current = $i == 0 ? '.' : '|';
            $textSize = $i > 1 && $i < count($texts) + 2 ? strlen($texts[$i - 2]) : $maxTextSize;
            $isOdd = $maxTextSize - $textSize % 2 === 1;
            
            for($j = 0; $j < $maxTextSize + ($padding * 2); $j++) {
                $current .= ($i == 0 || $i == 2 + count($texts)) ? '_' : 
                (($i == 1 || $j < $padding + (($maxTextSize - $textSize) / 2) ||
                $j >= $padding + $textSize + (($maxTextSize - $textSize) / 2)) ? ' ' : 
                $texts[$i - 2][$j - $padding - (int)((($maxTextSize - $textSize) + ($isOdd ? 0 : 1)) / 2 )]);
            }
                
            $current .= $i == 0 ? ". " : "| ";

            array_push($box, $current);          
        }
        
        return $box;
    }

    private function printList($list) {
        foreach($list as $item) {
            echo $item . "\n";
            usleep(40000);
        }
    }

    private function printText($text, $duration = 1, $startRow = 0) {
        if(gettype($text) == 'string') {
            $textLength = strlen($text);
            $delay = $duration / $textLength;
            $current = "";
    
            for ($i = 0; $i < $textLength; $i++) {
                $this->clearLine();
                $current .= $text[$i];
                echo $current;
                usleep((int)($delay * 100000));
            }

            return;
        }

        $rows = count($text);
        $cols = (int)(max(array_map('strlen', $text)) / 3);
        $totalCharacters = $rows * $cols;
    
        $delay = $duration / $totalCharacters;
        $output = array_fill(0, $rows, str_repeat('', $cols));
    
        for ($d = 0; $d < $rows + ($cols * 3); $d++) {
            for ($row = 0; $row <= $d; $row++) {
                $col = $d - $row;
    
                if ($row < $rows && $col < strlen($text[$row])) {
                    $output[$row][$col] = $text[$row][$col];
                }
            }

            for ($i = 0; $i < $rows; $i++) {
                echo "\033[" . ($startRow + $i + 1) . ";" . 1 . "H";
                echo "\033[K";
                echo $output[$i];
            }
    
            usleep((int)($delay * 100000)); 
        }
        
        echo "\n";
    }

    private function clearLine() {
        echo chr(27) . chr(91) . '2K';
        echo chr(27) . chr(91) . '0G';
    }

    private function clear() {
        echo chr(27).chr(91).'H'.chr(27).chr(91).'J'; 
    }
    
    private function validateInput($label, $expectedType = "string") {
        $input;
        
        if($expectedType == 'integer') {
            do {
                $input = (int) readline($label);

                if($input <= 0) {
                    $this->printText("Input must be an integer greater than 0.");
                    usleep(500000);
                    $this->clearLine();
                    echo "\033[F";
                    echo "\033[2K";
                }
            } while($input <= 0);
        }

        if($expectedType == "string") {
            do {
                $input = readline($label);

                if($input == "" || trim($input) == "") {
                    $this->printText("Input cannot be empty.");
                    usleep(500000);
                    $this->clearLine();
                    echo "\033[F";
                    echo "\033[2K";
                }
            } while($input == "");
        }

        if($expectedType == "float") {
            do {
                $input = (float) readline($label);

                if($input <= 0) {
                    $this->printText("Input must be a float/integer greater than 0.");
                    usleep(500000);
                    $this->clearLine();
                    echo "\033[F";
                    echo "\033[2K";
                }

            } while($input <= 0);
        }

        return $input;
    }
}