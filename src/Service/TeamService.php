<?php

namespace App\Service;

use App\Entity\Team;
use App\Entity\User;
use App\Repository\TeammateRepository;
use App\Repository\TeamRepository;

/**
 * This class implements utils methods for teams.
 * 
 * */
final class TeamService
{
    public function __construct(
        private TeamRepository $teamRepository, 
        private TeammateRepository $teammateRepository )
    {
        
    }

    /**
     * Create a slug based on the team name
     * 
     * @param string $name
     * @param string $divider
     * @return string
     */
    public static function slugify($name, string $divider = '-'):string
    {
        // replace non letter or digits by divider
        $name = preg_replace('~[^\pL\d]+~u', $divider, $name);

        // transliterate
        $name = iconv('utf-8', 'us-ascii//TRANSLIT', $name);

        // remove unwanted characters
        $name = preg_replace('~[^-\w]+~', '', $name);

        // trim
        $name = trim($name, $divider);

        // remove duplicate divider
        $name = preg_replace('~-+~', $divider, $name);

        // lowercase
        $name = strtolower($name);

        if (empty($name)) {
            return 'n-a';
        }

        return $name;
    }

    /**
     * Find if a slug already exists
     * 
     * @param string $name
     * @return boolean
     */
    public function slugExists(string $name, ): bool
    {
        $slug = self::slugify($name);

        $team = $this->teamRepository->findOneBy(['slug'=> $slug]);
        if($team) {
            return true;
        }
        
        return false;
    }

    /**
     * check if a user is already in the team
     * 
     * @param int $userId
     * @param int $teamId
     * @return boolean
     */
    public function checkIfUserIsATeam(int $teamId, int $userId) {
        $teammate = $this->teammateRepository->findOneBy(
            array(
                'user_id' => $userId,
                'team_id' => $teamId
            )
        );
        if($teammate) {
            return true;
        }
        return false;
    }
}
