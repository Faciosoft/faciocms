<?php
    namespace FacioCMS\Loader\Database; 

    class SQL {
        private \mysqli $connection;
        
        public static function Connect(\stdClass $config): SQL {
            $connection = new \mysqli($config->hostname, $config->username, $config->password, $config->database);

            if($connection->connect_error) {
                \FacioCMS\Error\ErrorHandler::Throw(
                    DATABASE_CONNECT_ERROR,
                    ""
                );
            }

            return new SQL($connection);
        }

        public function __construct($connection) {
            $this->connection = $connection;
        }

        public function CloseConnection() {
            if($this->connection->server_info) $this->connection->close();
        }

        public function HasDefault(): bool {
            $query = "DESCRIBE `fcms_coreconfig`";

            return !!$this->connection->query($query);
        }

        public function CreateDefault(): bool {
            $createTableQuery = "CREATE TABLE `fcms_coreconfig` ( `id` INT NOT NULL AUTO_INCREMENT , `version` TEXT NOT NULL , PRIMARY KEY (`id`))";
            $initConfigQuery = "INSERT INTO `fcms_coreconfig` VALUES (NULL, '3.0.0')";

            if($this->connection->query($createTableQuery)) {
                // Core Config Table Created
                // We can add config

                if($this->connection->query($initConfigQuery)) {
                    // Config added

                    return true;
                }
            }

            return false;
        }

        public function Select($query): array {
            if($result = $this->connection->query($query)) {
                if($result->num_rows > 0) {
                    $results = [];

                    while($row = $result->fetch_assoc()) {
                        $results[] = $row;
                    }

                    return $results;
                }

                return [];
            }

            \FacioCMS\Error\ErrorHandler::Throw(
                DATABASE_QUERY_ERROR,
                $query
            );

            return [];
        }

        public function Describe(string $tableName): bool {
            return !!$this->connection->query("DESCRIBE $tableName");
        }

        public function Raw(string $query): mixed {
            return $this->connection->query($query);
        }

        public function Escape(string $to_escape): string {
            return $this->connection->real_escape_string($to_escape);
        }
    }