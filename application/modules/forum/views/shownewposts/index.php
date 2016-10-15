<?php
$topics = $this->get('topics');
$forumMapper = $this->get('forumMapper');
$topicMapper = $this->get('topicMapper');
$postMapper = $this->get('postMapper');
$groupIdsArray = $this->get('groupIdsArray');
$adminAccess = null;
if ($this->getUser()) {
    $adminAccess = $this->getUser()->isAdmin();
}
?>

<link href="<?=$this->getModuleUrl('static/css/forum.css') ?>" rel="stylesheet">

<legend>
    <a href="<?=$this->getUrl(['controller' => 'index', 'action' => 'index']) ?>"><?=$this->getTrans('forum') ?></a> 
    <i class="forum fa fa-chevron-right"></i> <?=$this->getTrans('showNewPosts') ?>
</legend>
<div id="forum">
    <div class="forabg">
        <ul class="topiclist">
            <li class="header">
                <dl class="title">
                    <dt><?=$this->getTrans('topics') ?></dt>
                    <dd class="posts"><?=$this->getTrans('replies') ?> / <?=$this->getTrans('views') ?></dd>
                    <dd class="lastpost"><span><?=$this->getTrans('lastPost') ?></span></dd>
                </dl>
            </li>
        </ul>
        <ul class="topiclist topics">
            <?php foreach ($topics as $topic): ?>
                <?php $forum = $forumMapper->getForumById($topic->getTopicId()); ?>
                <?php $forumPrefix = $forumMapper->getForumByTopicId($topic->getId()) ?>
                <?php $firstPost = $postMapper->getPostByTopicId($topic->getId()) ?>
                <?php $lastPost = $topicMapper->getLastPostByTopicId($topic->getId()) ?>
                <?php if (is_in_array($groupIdsArray, explode(',', $forum->getReadAccess())) || $adminAccess == true): ?>
                    <?php $countPosts = $forumMapper->getCountPostsByTopicId($topic->getId()) ?>
                    <?php if (!in_array($this->getUser()->getId(), explode(',', $lastPost->getRead()))): ?>
                        <li class="row bg1">
                            <dl class="icon 
                                <?php if ($this->getUser()): ?>
                                    <?php if (in_array($this->getUser()->getId(), explode(',', $lastPost->getRead())) AND $topic->getStatus() == 0): ?>
                                        topic-read
                                    <?php elseif (in_array($this->getUser()->getId(), explode(',', $lastPost->getRead())) AND $topic->getStatus() == 1): ?>
                                        topic-read-locked
                                    <?php elseif ($topic->getStatus() == 1): ?>
                                        topic-unread-locked
                                    <?php else: ?>
                                        topic-unread
                                    <?php endif; ?>
                                <?php elseif ($topic->getStatus() == 1): ?>
                                    topic-read-locked
                                <?php else: ?>
                                    topic-read
                                <?php endif; ?>
                            ">
                                <dt title="<?=$firstPost[0]->getText() ?>">
                                    <?php
                                    if ($forumPrefix->getPrefix() != '' AND $topic->getTopicPrefix() > 0) {
                                        $prefix = explode(',', $forumPrefix->getPrefix());
                                        array_unshift($prefix, '');

                                        foreach ($prefix as $key => $value) {
                                            if ($topic->getTopicPrefix() == $key) {
                                                echo '<span class="label label-default">'.$value.'</span>';
                                            }
                                        }
                                    }
                                    ?>
                                    <a href="<?=$this->getUrl(['controller' => 'showposts', 'action' => 'index','topicid' => $topic->getId()]) ?>" class="topictitle">
                                        <?=$topic->getTopicTitle() ?>
                                    </a>
                                    <?php if ($topic->getType() == '1'): ?>
                                        <i class="fa fa-thumb-tack"></i>
                                    <?php endif; ?>
                                    <br>
                                    <div class="small">
                                        <?=$this->getTrans('by') ?>
                                        <a href="<?=$this->getUrl(['controller' => 'showposts', 'action' => 'index','topicid' => $topic->getId()]) ?>" style="color: #AA0000;" class="username-coloured">
                                            <?=$this->escape($topic->getAuthor()->getName()) ?>
                                        </a>
                                        »
                                        <?=$topic->getDateCreated() ?>
                                    </div>
                                </dt>
                                <dd class="posts small">
                                    <div class="pull-left text-nowrap stats">
                                        <?=$this->getTrans('replies') ?>:
                                        <br />
                                        <?=$this->getTrans('views') ?>:
                                    </div>
                                    <div class="pull-left text-justify">
                                        <?=$countPosts -1 ?>
                                        <br />
                                        <?=$topic->getVisits() ?>
                                    </div>
                                </dd>
                                <dd class="lastpost small">
                                    <div class="pull-left">
                                        <a href="<?=$this->getUrl(['module' => 'user', 'controller' => 'profil', 'action' => 'index', 'user' => $lastPost->getAutor()->getId()]) ?>" title="<?=$this->escape($lastPost->getAutor()->getName()) ?>">
                                            <img style="width:40px; padding-right: 5px;" src="<?=$this->getBaseUrl($lastPost->getAutor()->getAvatar()) ?>">
                                        </a>
                                    </div>
                                    <div class="pull-left">
                                        <?=$this->getTrans('by') ?>
                                        <a href="<?=$this->getUrl(['module' => 'user', 'controller' => 'profil', 'action' => 'index', 'user' => $lastPost->getAutor()->getId()]) ?>" title="<?=$this->escape($lastPost->getAutor()->getName()) ?>">
                                            <?=$this->escape($lastPost->getAutor()->getName()) ?>
                                        </a>
                                        <a href="<?=$this->getUrl(['controller' => 'showposts', 'action' => 'index','topicid' => $lastPost->getTopicId(), 'page' => $lastPost->getPage()]) ?>#<?=$lastPost->getId() ?>">
                                            <img src="<?=$this->getModuleUrl('static/img/icon_topic_latest.png') ?>" alt="<?=$this->getTrans('viewLastPost') ?>" title="<?=$this->getTrans('viewLastPost') ?>" height="10" width="12">
                                        </a>
                                        <br>
                                        <?=$lastPost->getDateCreated() ?>
                                    </div>
                                </dd>
                            </dl>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
