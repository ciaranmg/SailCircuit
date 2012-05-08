<?
/**
* Object Class for scoring system.
*/
class scoring_system 
{

	public $id, $name, $description, $race_ties, $dnc, $dns, $ocs, $bfd, $dnf, $dsq, $dne, $custom, $status, $club_id;
	
	function __construct($row = null)
	{
		if($row){
			$this->id = $row->id;
			$this->name = $row->name;
			$this->description = $row->description;
			$this->race_ties = $row->race_ties;
			$this->dnc = json_decode($row->dnc, true);
			$this->dns = json_decode($row->dns, true);
			$this->ocs = json_decode($row->ocs, true);
			$this->bfd = json_decode($row->bfd, true);
			$this->dnf = json_decode($row->dnf, true);
			$this->dsq = json_decode($row->dsq, true);
			$this->dne = json_decode($row->dne, true);
			$this->custom = $row->custom;
			$this->status = $row->status; 
			$this->club_id = $row->club_id;
		}
	}
}
?>