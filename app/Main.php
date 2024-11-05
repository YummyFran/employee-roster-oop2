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
            
            $choice = (int) readline("> ");

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
            default:
                $this->printText("Shutting down...");
                break;
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
        $name = readline("Name: ");
        $address = readline("Address: ");
        $company = readline("Company Name: ");
        $age = (int) readline("Age: ");

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
        $regularSalary = (float) readline("Regular salary: ");
        $itemsSold = (int) readline("Number of sold items: ");
        $commissionRate = (int) readline("Commission rate (%): ");

        $employee = new CommissionEmployee($regularSalary, $itemsSold, $commissionRate, $name, $address, $age, $company);

        $this->roster->add($employee) && $this->printText("Employee added successfully", 1);
    }

    private function addHourlyEmployee($name, $address, $company, $age) {

    }

    private function addPieceWorker($name, $address, $company, $age) {

    }
    
    private function deleteEmployee() {

    }

    private function otherMenu() {

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
            
            for($j = 0; $j < $maxTextSize + ($padding * 2); $j++) {
                $current .= ($i == 0 || $i == 2 + count($texts)) ? '_' : (($i == 1 || $j < $padding + (($maxTextSize - $textSize) / 2) || $j >= $padding + $textSize + (($maxTextSize - $textSize) / 2)) ? ' ' : $texts[$i - 2][$j - $padding - (int)(($maxTextSize - $textSize) / 2)]);
            }
                
            $current .= $i == 0 ? ". " : "| ";

            array_push($box, $current);          
        }
        
        return $box;
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
    
        for ($d = 0; $d < $rows + ($cols * 3) - 1; $d++) {
            for ($row = 0; $row <= $d; $row++) {
                $col = $d - $row;
    
                if ($row < $rows && $col < strlen($text[$row])) {
                    $output[$row][$col] = $text[$row][$col];
                }
            }

            for ($i = 0; $i < $rows; $i++) {
                echo "\033[" . ($startRow + $i + 1) . ";" . 1 . "H";
                echo "\033[K"; // Clear line from cursor
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
}