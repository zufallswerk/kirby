<?php

namespace Kirby\Cms;

/**
 * PageSiblings
 *
 * @package   Kirby Cms
 * @author    Bastian Allgeier <bastian@getkirby.com>
 * @link      https://getkirby.com
 * @copyright Bastian Allgeier GmbH
 * @license   https://getkirby.com/license
 */
trait PageSiblings
{
    /**
     * Checks if there's a next listed
     * page in the siblings collection
     *
     * @param \Kirby\Cms\Collection|null $collection
     *
     * @return bool
     */
    public function hasNextListed($collection = null): bool
    {
        return $this->nextListed($collection) !== null;
    }

    /**
     * Checks if there's a next unlisted
     * page in the siblings collection
     *
     * @param \Kirby\Cms\Collection|null $collection
     *
     * @return bool
     */
    public function hasNextUnlisted($collection = null): bool
    {
        return $this->nextUnlisted($collection) !== null;
    }

    /**
     * Checks if there's a previous listed
     * page in the siblings collection
     *
     * @param \Kirby\Cms\Collection|null $collection
     *
     * @return bool
     */
    public function hasPrevListed($collection = null): bool
    {
        return $this->prevListed($collection) !== null;
    }

    /**
     * Checks if there's a previous unlisted
     * page in the siblings collection
     *
     * @param \Kirby\Cms\Collection|null $collection
     *
     * @return bool
     */
    public function hasPrevUnlisted($collection = null): bool
    {
        return $this->prevUnlisted($collection) !== null;
    }

    /**
     * Returns the next listed page if it exists
     *
     * @param \Kirby\Cms\Collection|null $collection
     *
     * @return \Kirby\Cms\Page|null
     */
    public function nextListed($collection = null)
    {
        return $this->nextAll($collection)->listed()->first();
    }

    /**
     * Returns the next unlisted page if it exists
     *
     * @param \Kirby\Cms\Collection|null $collection
     *
     * @return \Kirby\Cms\Page|null
     */
    public function nextUnlisted($collection = null)
    {
        return $this->nextAll($collection)->unlisted()->first();
    }

    /**
     * Returns the previous listed page
     *
     * @param \Kirby\Cms\Collection|null $collection
     *
     * @return \Kirby\Cms\Page|null
     */
    public function prevListed($collection = null)
    {
        return $this->prevAll($collection)->listed()->last();
    }

    /**
     * Returns the previous unlisted page
     *
     * @param \Kirby\Cms\Collection|null $collection
     *
     * @return \Kirby\Cms\Page|null
     */
    public function prevUnlisted($collection = null)
    {
        return $this->prevAll($collection)->unlisted()->first();
    }

    /**
     * Private siblings collector
     *
     * @return \Kirby\Cms\Collection
     */
    protected function siblingsCollection()
    {
        if ($this->isDraft() === true) {
            return $this->parentModel()->drafts();
        } else {
            return $this->parentModel()->children();
        }
    }

    /**
     * Returns siblings with the same template
     *
     * @param bool $self
     * @return \Kirby\Cms\Pages
     */
    public function templateSiblings(bool $self = true)
    {
        return $this->siblings($self)->filterBy('intendedTemplate', $this->intendedTemplate()->name());
    }

    /**
     * @deprecated 3.0.0 Use `Page::hasNextUnlisted()` instead
     * @return bool
     */
    public function hasNextInvisible(): bool
    {
        deprecated('$page->hasNextInvisible() is deprecated, use $page->hasNextUnlisted() instead. $page->hasNextInvisible() will be removed in Kirby 3.5.0.');

        return $this->hasNextUnlisted();
    }

    /**
     * @deprecated 3.0.0 Use `Page::hasNextListed()` instead
     * @return bool
     */
    public function hasNextVisible(): bool
    {
        deprecated('$page->hasNextVisible() is deprecated, use $page->hasNextListed() instead. $page->hasNextVisible() will be removed in Kirby 3.5.0.');

        return $this->hasNextListed();
    }

    /**
     * @deprecated 3.0.0 Use `Page::hasPrevUnlisted()` instead
     * @return bool
     */
    public function hasPrevInvisible(): bool
    {
        deprecated('$page->hasPrevInvisible() is deprecated, use $page->hasPrevUnlisted() instead. $page->hasPrevInvisible() will be removed in Kirby 3.5.0.');

        return $this->hasPrevUnlisted();
    }

    /**
     * @deprecated 3.0.0 Use `Page::hasPrevListed()` instead
     * @return bool
     */
    public function hasPrevVisible(): bool
    {
        deprecated('$page->hasPrevVisible() is deprecated, use $page->hasPrevListed() instead. $page->hasPrevVisible() will be removed in Kirby 3.5.0.');

        return $this->hasPrevListed();
    }

    /**
     * @deprecated 3.0.0 Use `Page::nextUnlisted()` instead
     * @return self|null
     */
    public function nextInvisible()
    {
        deprecated('$page->nextInvisible() is deprecated, use $page->nextUnlisted() instead. $page->nextInvisible() will be removed in Kirby 3.5.0.');

        return $this->nextUnlisted();
    }


    /**
     * @deprecated 3.0.0 Use `Page::nextListed()` instead
     * @return self|null
     */
    public function nextVisible()
    {
        deprecated('$page->nextVisible() is deprecated, use $page->nextListed() instead. $page->nextVisible() will be removed in Kirby 3.5.0.');

        return $this->nextListed();
    }

    /**
     * @deprecated 3.0.0 Use `Page::prevUnlisted()` instead
     * @return self|null
     */
    public function prevInvisible()
    {
        deprecated('$page->prevInvisible() is deprecated, use $page->prevUnlisted() instead. $page->prevInvisible() will be removed in Kirby 3.5.0.');

        return $this->prevUnlisted();
    }

    /**
     * @deprecated 3.0.0 Use `Page::prevListed()` instead
     * @return self|null
     */
    public function prevVisible()
    {
        deprecated('$page->prevVisible() is deprecated, use $page->prevListed() instead. $page->prevVisible() will be removed in Kirby 3.5.0.');

        return $this->prevListed();
    }

    /**
     * Returns the next page in defined cycle
     *
     * @return Collection
     */
    public function nextCycle()
    {
        return $this->filterCycle($this->nextAll($this->siblingsCycle()))->first();
    }

    /**
     * Returns the prev page in defined cycle
     *
     * @return Collection
     */
    public function prevCycle()
    {
        return $this->filterCycle($this->prevAll($this->siblingsCycle()))->last();
    }

    /**
     * Returns siblings of defined cycle
     *
     * @return \Kirby\Toolkit\Collection
     */
    protected function siblingsCycle()
    {
        $cycle  = $this->blueprint()->cycle() ?? [];
        $sortBy = $cycle['sortBy'] ?? null;
        $status = $cycle['status'] ?? null;

        // if status is defined in cycle, all items in the collection are used (drafts, listed and unlisted)
        // otherwise it depends on the status of the page
        $collection = $status !== null ? $this->parentModel()->childrenAndDrafts() : $this->siblingsCollection();

        // sort the collection if custom sortBy defined in cycle
        // otherwise default sorting will apply
        if ($sortBy !== null) {
            return $collection->sortBy(...$collection::sortArgs($sortBy));
        }

        return $collection;
    }

    /**
     * Returns filtered siblings for defined cycle
     *
     * @param Collection $collection
     * @return \Kirby\Cms\Collection
     */
    protected function filterCycle(Collection $collection)
    {
        $cycle = $this->blueprint()->cycle() ?? [];

        if (empty($cycle) === false) {
            $status   = $cycle['status'] ?? $this->status();
            $template = $cycle['template'] ?? $this->intendedTemplate();

            $statuses  = is_array($status) === true ? $status : [$status];
            $templates = is_array($template) === true ? $template : [$template];

            // do not filter if template cycle is all
            if (in_array('all', $templates) === false) {
                $collection = $collection->filterBy('intendedTemplate', 'in', $templates);
            }

            // do not filter if status cycle is all
            if (in_array('all', $statuses) === false) {
                $collection = $collection->filterBy('status', 'in', $statuses);
            }
        } else {
            $collection = $collection
                ->filterBy('intendedTemplate', $this->intendedTemplate())
                ->filterBy('status', $this->status());
        }

        return $collection->filterBy('isReadable', true);
    }
}
