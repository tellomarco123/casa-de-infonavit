<?php
/**
 *
 */
class Database extends PDO
{
  private static $host;
  public static $db;
  private static $user;
  private static $password;
  private static $charset;
  private static $conectionInstance = null;

  private function __construct()
  {

  }

  public static function OpenDbConection() //Use onli if there isn't db conections instance
  {
    if (self::$conectionInstance === null) {
      self::$host = constant("HOST"); // Get host from constant

      self::$db = constant("DB"); // Get database name from constant

      self::$user = constant("USER"); // Get user from constant

      self::$password = constant("PASSWORD"); // Get password from constant

      self::$charset = constant("CHARSET"); // Get charset from constant

      try {

        $connection = "mysql:host=" . self::$host . ";dbname=" . self::$db; // Build connection string

        $options = [ // PDO options

          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Error mode: exceptions

          PDO::ATTR_EMULATE_PREPARES => false // Disable prepared statement emulation

        ];

        self::$conectionInstance = new PDO($connection, self::$user, self::$password, $options); // Create PDO instance

      } catch (PDOException $e) { // Catch PDO exceptions

        echo "Database connection error: " . $e->getMessage() . PHP_EOL; // Display detailed error message

        exit; // Exit script

      }
      return self::$conectionInstance; // Return connection instance
    }

  }
}