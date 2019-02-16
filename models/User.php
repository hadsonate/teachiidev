<?php
class User
{
    private $username;
    private $lastname;
	private $name;
	private $age;
	private $email;
	private $dob;

	public function __construct()
    {
        if (isset($_SESSION['account_data'])) {
            $account = $_SESSION['account_data'];
            $this->username = $account['username'];
            $this->name = $account['first_name'];
            $this->lastname = $account['last_name'];
            $this->dob = $account['date_of_birth'];
            $dob = new DateTime($this->dob);
            $now = new DateTime();
            $this->age = $now->diff($dob)->y;
            $this->email = $account['email'];

        }
    }

    public function getUsername()
    {
        return $this->username;
    }
    public function setUsername($name)
    {
        $this->username= $name;
    }

    public function getName()
	{
		return $this->name;
	}
	public function setName($name)
	{
		$this->name= $name;
	}
	
	public function getAge()
	{
		return $this->age;
	}
	public function setAde($name)
	{
		$this->age= $name;
	}

    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail($email)
    {
        $this->email= $email;
    }

    public function getLastname()
    {
        return $this->lastname;
    }
    public function setLastname($name)
    {
        $this->lastname= $name;
    }

    public function getDob()
    {
        return $this->dob;
    }
    public function setDob($dob)
    {
        $this->dob = $dob;
    }
}