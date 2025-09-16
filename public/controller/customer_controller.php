<?php
class CustomerController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllCustomers() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM khachhang");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getCustomerById($id) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM khachhang WHERE KH_ID = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    public function createCustomer($data) {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO khachhang (KH_Ten, KH_SDT, KH_Email, KH_DiaChi) 
                VALUES (?, ?, ?, ?)
            ");
            return $stmt->execute([
                $data['KH_Ten'], 
                $data['KH_SDT'], 
                $data['KH_Email'], 
                $data['KH_DiaChi']
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function updateCustomer($id, $data) {
        try {
            $stmt = $this->pdo->prepare("
                UPDATE khachhang 
                SET KH_Ten = ?, KH_SDT = ?, KH_Email = ?, KH_DiaChi = ? 
                WHERE KH_ID = ?
            ");
            return $stmt->execute([
                $data['KH_Ten'], 
                $data['KH_SDT'], 
                $data['KH_Email'], 
                $data['KH_DiaChi'], 
                $id
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }

    public function deleteCustomer($id) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM khachhang WHERE KH_ID = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>