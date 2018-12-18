<?php

namespace KevCooper\TerminusFreeze\Commands;

use Pantheon\Terminus\Commands\TerminusCommand;
use Pantheon\Terminus\Site\SiteAwareInterface;
use Pantheon\Terminus\Site\SiteAwareTrait;

/**
 * Class UnfreezeCommand
 * 
 * @package KevCooper\TerminusFreeze\Commands
 */
class UnfreezeCommand extends TerminusCommand implements SiteAwareInterface
{
    use SiteAwareTrait;

    /**
     * Unfreezes a site.
     *
     * @authorize
     *
     * @command site:unfreeze
     *
     * @param string $site_id The name or UUID of a site to unfreeze
     *
     * @usage <site> Unfreezes <site>.
     */
    public function unfreeze($site_id)
    {
        $site = $this->getSite($site_id);
        if ($site->isFrozen()) {
            $site->getWorkflows()->create('unfreeze_site', []);
            $this->log()->notice(
                'Unfroze {site}',
                ['site' => $site->get('name')]
            );
        } else {
            $this->log()->notice(
                '{site} is not frozen',
                ['site' => $site->get('name')]
            );
        }
    }
}
