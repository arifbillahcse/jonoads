<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Seeder;

class TeamMemberSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            [
                'name' => 'Joseph',
                'role' => 'Founder & CEO',
                'bio' => 'Among the world\'s most experienced digital advertising professionals, with $250M in media managed, ~$750M in revenue generated, and over 150,000 ads launched. He\'s scaled 30+ brands, managed media for seven billion-dollar companies, and worked with 70+ brands total.
Acclaimed for paid social advertising, Joseph has doubled client ROAS and monthly budget more than twenty times, and is undefeated against the marketing science teams at the top ad networks for eight consecutive years — nineteen pitches, zero losses.
He spent roughly 14 years at billion-dollar brands and is the first two-time recipient of the Brand Innovator Top 40 Under 40 Award. Joseph has spoken at Dreamforce, Spreadfast Summit, Social Loco, Mobile Loco, and the Corporate Social Media Summit, and regularly lectures in MBA programs at USC, Columbia, and George Washington University.',
                'initials' => 'J',
                'is_founder' => true,
            ],
            [
                'name' => 'Mike Smart',
                'role' => 'Head of Client Success',
                'bio' => 'Go-to-market expert with two decades launching the world\'s most popular consumer electronics and Apple ecosystem brands. Deep manufacturer and retailer relationships across the US and Southeast Asia.',
                'initials' => 'MS',
                'is_founder' => false,
            ],
            [
                'name' => 'Phil Irvine',
                'role' => 'CRM + Lifecycle',
                'bio' => 'Transformational marketing executive with two decades driving DTC and omni-channel growth from early stage to $1B+ organizations. Named one of Business Insider\'s "42 Rising Stars in Adtech."',
                'initials' => 'PI',
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
            [
                'name' => 'Nicole Dunn',
                'role' => 'Public Relations, CEO of DPM PR',
                'bio' => 'Founded DPM PR to bring positive health coverage to media. The firm elevates brands, experts, and healthcare providers in health, wellness, and lifestyle — and regularly contributes to Forbes.',
                'initials' => 'ND',
                'is_founder' => false,
            ],
        ] as $i => $row) {
            TeamMember::create($row + ['sort_order' => $i + 1]);
        }
    }
}
