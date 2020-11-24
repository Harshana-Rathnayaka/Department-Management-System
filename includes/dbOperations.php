<?php

class DbOperations
{

    private $con;

    public function __construct()
    {

        require_once dirname(__FILE__) . '/dbConnection.php';

        $db = new DbConnect();

        $this->con = $db->connect();
    }

    /* CRUD  -> C -> CREATE */

    // addding new user
    public function createUser($fullname, $username, $email, $pass, $usertype, $department)
    {
        $password = md5($pass); // password hashing
        if ($this->isUserExist($username, $email)) {
            // user exists
            return 0;
        } else {
            $stmt = $this->con->prepare("INSERT INTO `users` (`id`, `fullname`, `username`, `email`, `password`, `user_type`, `department_id`, `status`, `attempts`) VALUES (NULL, ?, ?, ?, ?, ?, ?, 1, 0);");
            $stmt->bind_param("ssssss", $fullname, $username, $email, $password, $usertype, $department);

            if ($stmt->execute()) {
                // user created
                return 1;
            } else {
                // some error
                return 2;
            }
        }
    }

    // addding new email
    public function createEmail($name, $email)
    {
        $stmt = $this->con->prepare("INSERT INTO `senior_managers`(`senior_manager_id`, `senior_manager_name`, `senior_manager_email`) VALUES (NULL, ?, ?);");
        $stmt->bind_param("ss", $name, $email);

        if ($stmt->execute()) {
            // email created
            return 0;
        } else {
            // some error
            return 1;
        }

    }

    // user login
    public function userLogin($username, $pass)
    {
        $password = md5($pass); // password decrypting
        $stmt = $this->con->prepare("SELECT `id` FROM `users` WHERE `username` = ? AND `password` = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    // updating OTP
    public function updateUserOTP($user_id, $otp)
    {
        $stmt = $this->con->prepare("UPDATE `users` SET `otp` = ? WHERE `id` = ?");
        $stmt->bind_param("si", $otp, $user_id);

        if ($stmt->execute()) {
            // otp updated
            return 0;
        } else {
            // some error
            return 1;
        }
    }

    // updating login attempts
    public function updateLoginAttempts($ip_address, $timestamp)
    {
        $stmt = $this->con->prepare("INSERT INTO `login_attempts` (`attempt_id`, `ip_address`, `timestamp`) VALUES (NULL, ?, ?);");
        $stmt->bind_param("ss", $ip_address, $timestamp);

        if ($stmt->execute()) {
            // login attempt added
            return 0;
        } else {
            // some error
            return 1;
        }
    }

    // retrieving login attempts
    public function getLoginAttempts($time, $user_ip)
    {
        $stmt = $this->con->prepare("SELECT COUNT(*) AS `total_count` FROM `login_attempts` WHERE `timestamp` > ? AND `ip_address` = ?;");
        $stmt->bind_param("ss", $time, $user_ip);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // deleting login attempts
    public function deleteLoginAttempts($ip_address)
    {
        $stmt = $this->con->prepare("DELETE FROM `login_attempts` WHERE `ip_address` = ?");
        $stmt->bind_param("s", $ip_address);

        if ($stmt->execute()) {
            // login attempt deleted
            return 0;
        } else {
            // some error
            return 1;
        }
    }

    // adding new department
    public function createDepartment($name)
    {
        if ($this->isDepartmentExist($name)) {
            // department exists
            return 0;
        } else {
            $stmt = $this->con->prepare("INSERT INTO `departments` (`department_id`, `department_name`) VALUES (NULL, ?);");
            $stmt->bind_param("s", $name);

            if ($stmt->execute()) {
                // department created
                return 1;
            } else {
                // some error
                return 2;
            }
        }
    }

    // adding to orders
    public function placeOrder($user_id, $department_id, $item, $quantity, $order_details)
    {
        $stmt = $this->con->prepare("INSERT INTO `orders`(`user_id`, `department_id`, `item`, `quantity`, `order_details`) VALUES (?, ?, ?, ?, ?); ");
        $stmt->bind_param("iisss", $user_id, $department_id, $item, $quantity, $order_details);

        if ($stmt->execute()) {
            // added to orders table
            return 1;
        } else {
            // some error
            return 2;
        }
    }

    // adding to user login log
    public function addToLoginLog($user_id, $ip_address)
    {
        $stmt = $this->con->prepare("INSERT INTO `login_log` (`user_id`, `login_ip`) VALUES (?, ?);");
        $stmt->bind_param("is", $user_id, $ip_address);

        if ($stmt->execute()) {
            // added to login log table
            return 1;
        } else {
            // some error
            return 2;
        }
    }

    /* CRUD  -> r -> RETRIEVE */

    // retreiving user data by username
    public function getUserByUsername($username)
    {
        $stmt = $this->con->prepare("SELECT * FROM `users` WHERE `username` = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // retreiving user data by id
    public function getAccountDetails($user_id)
    {
        $stmt = $this->con->prepare("SELECT * FROM `users` WHERE `id` = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // checking if the user exists
    private function isUserExist($username, $email)
    {
        $stmt = $this->con->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    // checking if the email is taken
    public function isEmailTaken($email)
    {
        $stmt = $this->con->prepare("SELECT * FROM `users` WHERE `email` = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    // checking if the username is taken
    public function isUsernameTaken($username)
    {
        $stmt = $this->con->prepare("SELECT * FROM `users` WHERE `username` = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    // checking if the department exists
    private function isDepartmentExist($name)
    {
        $stmt = $this->con->prepare("SELECT `department_id` FROM `departments` WHERE `department_name` = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    /*
    ======= ADMIN ========
     */

    // retrieving departments table
    public function getDepartments()
    {
        $stmt = $this->con->prepare("SELECT * FROM `departments`");
        $stmt->execute();
        return $stmt->get_result();
    }

    // retrieving users table
    public function getUsers()
    {
        $stmt = $this->con->prepare("SELECT * FROM `users` INNER JOIN `departments` ON departments.department_id = users.department_id WHERE `user_type` != 0");
        $stmt->execute();
        return $stmt->get_result();
    }

    // retrieving orders table
    public function getOrders()
    {
        $stmt = $this->con->prepare("SELECT * FROM `orders`");
        $stmt->execute();
        return $stmt->get_result();
    }

    // retrieving emails table
    public function getEmails()
    {
        $stmt = $this->con->prepare("SELECT * FROM `senior_managers`");
        $stmt->execute();
        return $stmt->get_result();
    }

    // retrieving login log table
    public function getLoginLog()
    {
        $stmt = $this->con->prepare("SELECT * FROM `login_log` INNER JOIN users ON users.id = login_log.user_id");
        $stmt->execute();
        return $stmt->get_result();
    }

    // retreiving orders by created date
    public function getOrdersByDate($today_date, $yesterday_date)
    {
        $stmt = $this->con->prepare("SELECT * FROM `orders` INNER JOIN `departments` ON departments.department_id = orders.department_id
        INNER JOIN `users` ON users.id = orders.user_id WHERE `placed_on` <= ? AND `placed_on` >= ? ORDER BY `order_id`");
        $stmt->bind_param("ss", $today_date, $yesterday_date);
        $stmt->execute();
        return $stmt->get_result();
    }

    /*
    ======= TEAM LEADER ========
     */

    // retrieving pending orders by user id
    public function getPendingOrdersByUserId($user_id)
    {
        $stmt = $this->con->prepare("SELECT * FROM `orders` INNER JOIN `departments` ON departments.department_id = orders.department_id
		WHERE `user_id` = ? AND `order_status` = 0 ORDER BY `order_id`");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    // retrieving cancelled orders by user id
    public function getCancelledOrdersByUserId($user_id)
    {
        $stmt = $this->con->prepare("SELECT * FROM `orders` INNER JOIN `departments` ON departments.department_id = orders.department_id
		WHERE `user_id` = ? AND `order_status` = 3 ORDER BY `order_id`");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    // retrieving completed orders by user id
    public function getCompletedOrdersByUserId($user_id)
    {
        $stmt = $this->con->prepare("SELECT * FROM `orders` INNER JOIN `departments` ON departments.department_id = orders.department_id
		WHERE `user_id` = ? AND `order_status` = 2 ORDER BY `order_id`");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    // retrieving completed orders by user id
    public function getAllOrdersByUserId($user_id)
    {
        $stmt = $this->con->prepare("SELECT * FROM `orders` INNER JOIN `departments` ON departments.department_id = orders.department_id
		WHERE `user_id` = ? ORDER BY `order_id`");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    /*
    ======= DEPARTMENT MANAGER ========
     */

    // retrieving all orders by department id
    public function getAllOrdersByDepartment($department_id)
    {
        $stmt = $this->con->prepare("SELECT * FROM `orders` WHERE `department_id` = ?");
        $stmt->bind_param("s", $department_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    // retrieving all pending orders by department id
    public function getPendingOrdersByDepartment($department_id)
    {
        $stmt = $this->con->prepare("SELECT * FROM `orders` WHERE `department_id` = ? AND `order_status` = 0");
        $stmt->bind_param("s", $department_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    // retrieving all rejected orders by department id
    public function getRejectedOrdersByDepartment($department_id)
    {
        $stmt = $this->con->prepare("SELECT * FROM `orders` WHERE `department_id` = ? AND `order_status` = 3");
        $stmt->bind_param("s", $department_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    // retrieving all the completed orders by department id
    public function getCompletedOrdersByDepartment($department_id)
    {
        $stmt = $this->con->prepare("SELECT * FROM `orders` WHERE `department_id` = ? AND `order_status` = 2");
        $stmt->bind_param("s", $department_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    /*
    ======= FINANCE DEPARTMENT ========
     */

    // retrieving the approved orders table for the finance department
    public function getPendingOrdersForFinance()
    {
        $stmt = $this->con->prepare("SELECT * FROM `orders` WHERE `order_status` = 1");
        $stmt->execute();
        return $stmt->get_result();
    }

    // retrieveing all time orders without pending orders for finance department
    public function getAllOrdersForFinance()
    {
        $stmt = $this->con->prepare("SELECT * FROM `orders` INNER JOIN `departments` ON departments.department_id = orders.department_id  WHERE `order_status` != 0");
        $stmt->execute();
        return $stmt->get_result();
    }

    // retrieving all the cancelled orders for finance department
    public function getCancelledOrdersForFinance()
    {
        $stmt = $this->con->prepare("SELECT * FROM `orders` WHERE  `order_status` = 3");
        $stmt->execute();
        return $stmt->get_result();
    }

    // retrieving all the completed orders for finance department
    public function getCompletedOrdersForFinance()
    {
        $stmt = $this->con->prepare("SELECT * FROM `orders` WHERE  `order_status` = 2");
        $stmt->execute();
        return $stmt->get_result();
    }

    // retrieving pending orders to user
    public function getPendingOrdersById($user_id)
    {
        $stmt = $this->con->prepare("SELECT * FROM `orders` INNER JOIN `users` ON users.id = orders.user_id
		WHERE `user_id` = ? AND `order_status` = 0 ORDER BY `order_id`");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    // getting the orders count by user
    public function getOrdersCountByUserId($user_id)
    {
        $stmt = $this->con->prepare("SELECT * FROM `orders` WHERE `user_id` = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return mysqli_num_rows($result);
    }

    // getting the cart count by user
    public function getCartCountByUserId($user_id)
    {
        $stmt = $this->con->prepare("SELECT * FROM `cart` WHERE `user_id` = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return mysqli_num_rows($result);
    }

    /* CRUD  -> U -> UPDATE */

    // deactivate user account  by updating user status
    public function deleteAccountById($user_id)
    {
        $stmt = $this->con->prepare("UPDATE `users` SET `user_status` = 0 WHERE `id` = ?");
        $stmt->bind_param("i", $user_id);

        if ($stmt->execute()) {
            // user account status updated and account deactivated
            return 0;
        } else {
            // some error
            return 1;
        }
    }

    // update an order by user
    public function updateOrderByUser($order_id, $item, $quantity, $order_details, $cancel)
    {
        $status;

        if ($cancel == null) {
            $status = 0;
        } else {
            $status = $cancel;
        }

        $stmt = $this->con->prepare("UPDATE `orders` SET `item` = ?, `quantity` = ?, `order_details` = ?, `order_status` = ? WHERE `order_id` = ?");
        $stmt->bind_param("sssii", $item, $quantity, $order_details, $status, $order_id);

        if ($stmt->execute()) {
            // order updated
            return 0;
        } else {
            // some error
            return 1;
        }
    }

    // update an order by managers and finance department
    public function updateOrderStatus($order_id, $status)
    {
        $stmt = $this->con->prepare("UPDATE `orders` SET `order_status` = ? WHERE `order_id` = ?");
        $stmt->bind_param("ii", $status, $order_id);

        if ($stmt->execute()) {
            // order status updated by managers and finance departmet manager
            return 0;
        } else {
            // some error
            return 1;
        }
    }

    // update user status (Activating and Suspending)
    public function updateUserStatus($user_id, $user_status)
    {
        $stmt = $this->con->prepare("UPDATE `users` SET `status` = ? WHERE `id` = ?");
        $stmt->bind_param("ii", $user_status, $user_id);

        if ($stmt->execute()) {
            // user status updated
            return 0;
        } else {
            // some error
            return 1;
        }
    }

    // update user profile details
    public function updateProfile($userid, $fullname, $username, $email)
    {
        $stmt = $this->con->prepare("UPDATE `users` SET `fullname` = ?, `username` = ?, `email` = ? WHERE `id` = ?");
        $stmt->bind_param("sssi", $fullname, $username, $email, $userid);

        if ($stmt->execute()) {
            // account details updated
            return 0;
        } else {
            // some error
            return 1;
        }
    }

    // update departments
    public function updateDepartments($department_id, $department_name)
    {
        $stmt = $this->con->prepare("UPDATE `departments` SET `department_name` = ? WHERE `department_id` = ?");
        $stmt->bind_param("si", $department_name, $department_id);

        if ($stmt->execute()) {
            // department updated
            return 0;
        } else {
            // some error
            return 1;
        }
    }

    // update senior management accounts
    public function updateEmail($senior_manager_id, $senior_manager_name, $senior_manager_email)
    {
        $stmt = $this->con->prepare("UPDATE `senior_managers` SET `senior_manager_name` = ?, `senior_manager_email` = ? WHERE `senior_manager_id` = ?");
        $stmt->bind_param("ssi", $senior_manager_name, $senior_manager_email, $senior_manager_id);

        if ($stmt->execute()) {
            // senior manager account updated
            return 0;
        } else {
            // some error
            return 1;
        }
    }

}
