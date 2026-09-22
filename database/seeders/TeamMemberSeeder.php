<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class TeamMemberSeeder extends Seeder
{
    /**
     * Client feedback round 1: the founder is named in full, his bio was
     * rewritten, and the grid order changed twice over — Nicole Hidalgo and
     * Phil Irvine swap on the top row, and the bottom row now reads Nicole
     * Dunn, Tom Pelligrino, Bill Bradford.
     *
     * Order below is the order the 3-column grid renders, top row first.
     * (Nicole Hidalgo and Nicole Dunn are two different people — the
     * feedback names both, which is easy to misread as one typo.)
     */
    public function run(): void
    {
        foreach ([
            [
                'name' => 'Joseph Nolan',
                'role' => 'Founder & CEO',
                'bio' => 'Joseph is among the world\'s most successful and experienced digital advertising pros with $250M media managed, ~$750M revenue generated and over 150,000 ads launched. He\'s scaled >40 brands, managed media for 7 billion-dollar companies and worked with >70 brands.
Acclaimed for paid social advertising, he\'s doubled client ROAS and monthly budget over 20 times and is undefeated versus the marketing science teams at the top ad networks for eight consecutive years (24-0). He\'s also outperformed every client\'s previous team (>35 brands).
Joseph spent 14 years at billion-dollar brands and is the first two-time recipient of the Brand Innovator Top 40 Under 40 Award. He showcased at the world\'s most popular marketing/digital events like Dreamforce, Spreadfast Summit, Social Loco, Mobile Loco and Corporate Social Media Summit. Joseph regularly lectures in MBA programs at USC (alum), Columbia Univ., and George Washington Univ., among others.',
                'initials' => 'JN',
                'is_founder' => true,
            ],

            // ---- Top row --------------------------------------------------
            [
                'name' => 'Mike Smart',
                'role' => 'Head of Client Success',
                'bio' => 'Go-to-market expert with two decades launching the world\'s most popular consumer electronics and Apple ecosystem brands. Deep manufacturer and retailer relationships across the US and Southeast Asia.',
                'initials' => 'MS',
                'is_founder' => false,
            ],
            [
                'name' => 'Nicole Hidalgo',
                'role' => 'Social Media + Content',
                'bio' => 'Founder of 197, a strategy-first creative growth agency aligning positioning, messaging, creative, and performance into one operating system built for scale.',
                'initials' => 'NH',
                'is_founder' => false,
            ],
            [
                'name' => 'Phil Irvine',
                'role' => 'CRM + Lifecycle',
                'bio' => 'Transformational marketing executive with two decades driving DTC and omni-channel growth from early stage to $1B+ organizations. Named one of Business Insider\'s "42 Rising Stars in Adtech."',
                'initials' => 'PI',
                'is_founder' => false,
            ],

            // ---- Bottom row -----------------------------------------------
            [
                'name' => 'Nicole Dunn',
                'role' => 'Public Relations, CEO of DPM PR',
                'bio' => 'Founded DPM PR to bring positive health coverage to media. The firm elevates brands, experts, and healthcare providers in health, wellness, and lifestyle — and regularly contributes to Forbes.',
                'initials' => 'ND',
                'is_founder' => false,
            ],
            [
                'name' => 'Tom Pelligrino',
                'role' => 'Creative Engineer',
                'bio' => 'A decade at premier brand-creative agencies, transforming messaging and identity for national clients. Two-plus years at the forefront of AI for creative strategy and performance advertising.',
                'initials' => 'TP',
                'is_founder' => false,
            ],
            [
                'name' => 'Bill Bradford',
                'role' => 'Advisor + Executive Leadership',
                'bio' => 'Recognized executive leader in eCommerce and digital transformation, having led large, profitable digital divisions at Fox, Beachbody, AOL, Yahoo!, Oracle, and Wondr Health.',
                'initials' => 'BB',
                'is_founder' => false,
            ],
        ] as $i => $row) {
            TeamMember::create($row + ['sort_order' => $i + 1]);
        }
    }
}
