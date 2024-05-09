<?php
use PHPUnit\Framework\TestCase;

class BloodRequirerTest extends TestCase
{
    private $dbh; // Database handle

    // Set up the test environment (e.g., create a new database connection)
    protected function setUp(): void
    {
        // Initialize a new database connection for testing
        // Assuming your includes/config.php sets up the $dbh connection
        include('includes/config.php');
        $this->dbh = $dbh;
    }

    // Clean up after each test (e.g., close the database connection)
    protected function tearDown(): void
    {
        // Close the database connection if necessary
        $this->dbh = null;
    }

    public function testAddBloodRequirer()
    {
        // Define input values for the test
        $name = 'Test User';
        $email = 'test@example.com';
        $contactNo = '1234567890';
        $bloodRequireFor = 'Mother';
        $message = 'This is a test message';
        $cid = 1; // Assume you have a valid BloodDonarID

        // Prepare the SQL statement
        $sql = "INSERT INTO tblbloodrequirer (BloodDonarID, name, EmailId, ContactNumber, BloodRequirefor, Message)
                VALUES (:cid, :name, :email, :contactNo, :bloodRequireFor, :message)";
        $query = $this->dbh->prepare($sql);

        // Bind parameters
        $query->bindParam(':cid', $cid, PDO::PARAM_INT);
        $query->bindParam(':name', $name, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);
        $query->bindParam(':contactNo', $contactNo, PDO::PARAM_STR);
        $query->bindParam(':bloodRequireFor', $bloodRequireFor, PDO::PARAM_STR);
        $query->bindParam(':message', $message, PDO::PARAM_STR);

        // Execute the query
        $query->execute();

        // Retrieve the last inserted ID
        $lastInsertId = $this->dbh->lastInsertId();

        // Assert that the last insert ID is not null
        $this->assertNotNull($lastInsertId, 'The last insert ID should not be null.');

        // Optionally, assert that the inserted data matches the expected data
        $sql = "SELECT * FROM tblbloodrequirer WHERE id = :lastInsertId";
        $query = $this->dbh->prepare($sql);
        $query->bindParam(':lastInsertId', $lastInsertId, PDO::PARAM_INT);
        $query->execute();
        
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        // Check if the data matches the expected data
        $this->assertNotNull($result, 'Data should exist in the database.');
        $this->assertEquals($name, $result['name']);
        $this->assertEquals($email, $result['EmailId']);
        $this->assertEquals($contactNo, $result['ContactNumber']);
        $this->assertEquals($bloodRequireFor, $result['BloodRequirefor']);
        $this->assertEquals($message, $result['Message']);
    }
}
?>