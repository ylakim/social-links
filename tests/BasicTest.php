<?php
use SocialLinks\Page;

class BasicTest extends PHPUnit_Framework_TestCase
{
    public function testPage()
    {
        $info = array(
            'url' => 'http://mypage.com',
            'title' => 'Page title',
            'text' => 'Extended page description',
            'image' => 'http://mypage.com/image.png',
            'twitterUser' => '@twitterUser',
        );

        $page = new Page($info);

        $this->assertEquals($info['url'], $page->getUrl());
        $this->assertEquals(array('title' => $info['title']), $page->get(array('title')));
        $this->assertEquals($info, $page->get());

        return $page;
    }

    /**
     * @depends testPage
     */
    public function testProviders(Page $page)
    {
        $this->assertEquals($page->blogger->shareUrl, 'https://www.blogger.com/blog-this.g?u=http%3A%2F%2Fmypage.com&n=Page+title');
        $this->assertEquals($page->bobrdobr->shareUrl, 'http://bobrdobr.ru/addext.html?url=http%3A%2F%2Fmypage.com&title=Page+title&desc=Extended+page+description');
        $this->assertEquals($page->cabozo->shareUrl, 'http://www.cabozo.com/share.php?url=http%3A%2F%2Fmypage.com');
        $this->assertEquals($page->chuza->shareUrl, 'http://chuza.gl/submit.php?url=http%3A%2F%2Fmypage.com');
        $this->assertEquals($page->email->shareUrl, 'mailto:?subject=Page%20title&body=Extended%20page%20description%0Ahttp%3A%2F%2Fmypage.com');
        $this->assertEquals($page->evernote->shareUrl, 'https://www.evernote.com/clip.action?url=http%3A%2F%2Fmypage.com&title=Page+title&body=Extended+page+description');
        $this->assertEquals($page->facebook->shareUrl, 'https://www.facebook.com/sharer.php?s=100&p%5Burl%5D=http%3A%2F%2Fmypage.com&p%5Btitle%5D=Page+title&p%5Bsummary%5D=Extended+page+description&p%5Bimages%5D%5B0%5D=http%3A%2F%2Fmypage.com%2Fimage.png');
        $this->assertEquals($page->linkedin->shareUrl, 'https://www.linkedin.com/shareArticle?mini=1&url=http%3A%2F%2Fmypage.com&title=Page+title&summary=Extended+page+description');
        $this->assertEquals($page->liveinternet->shareUrl, 'http://www.liveinternet.ru/journal_post.php?action=n_add&cnurl=http%3A%2F%2Fmypage.com&cntitle=Page+title');
        $this->assertEquals($page->livejournal->shareUrl, 'http://www.livejournal.com/update.bml?event=%3Ca+href%3D%22http%3A%2F%2Fmypage.com%22%3EPage+title%3C%2Fa%3E&subject=Page+title');
        $this->assertEquals($page->mailru->shareUrl, 'http://connect.mail.ru/share?url=http%3A%2F%2Fmypage.com&title=Page+title&description=Extended+page+description&imageurl=http%3A%2F%2Fmypage.com%2Fimage.png');
        $this->assertEquals($page->meneame->shareUrl, 'http://meneame.net/submit.php?url=http%3A%2F%2Fmypage.com');
        $this->assertEquals($page->odnoklassniki->shareUrl, 'http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st._surl=http%3A%2F%2Fmypage.com');
        $this->assertEquals($page->pinterest->shareUrl, 'https://www.pinterest.com/pin/create/button/?url=http%3A%2F%2Fmypage.com&description=Page+title&media=http%3A%2F%2Fmypage.com%2Fimage.png');
        $this->assertEquals($page->plus->shareUrl, 'https://plus.google.com/share?url=http%3A%2F%2Fmypage.com');
        $this->assertEquals($page->stumbleupon->shareUrl, 'https://www.stumbleupon.com/submit?url=http%3A%2F%2Fmypage.com&title=Page+title');
        $this->assertEquals($page->tumblr->shareUrl, 'https://www.tumblr.com/share?v=3&u=http%3A%2F%2Fmypage.com&t=Page+title');
        $this->assertEquals($page->twitter->shareUrl, 'https://twitter.com/intent/tweet?text=Page+title+via+%40twitterUser&url=http%3A%2F%2Fmypage.com');
        $this->assertEquals($page->vk->shareUrl, 'http://vk.com/share.php?url=http%3A%2F%2Fmypage.com&description=Extended+page+description&image=http%3A%2F%2Fmypage.com%2Fimage.png');
    }

    /**
     * @depends testPage
     */
    public function testMetas(Page $page)
    {
        $twitterCard = implode('', (array) $page->twitterCard());
        $openGraph = implode('', (array) $page->openGraph());
        $html = implode('', (array) $page->html());

        $this->assertEquals($twitterCard, '<meta property="twitter:card" content="summary"><meta property="twitter:title" content="Page title"><meta property="twitter:image" content="http://mypage.com/image.png"><meta property="twitter:description" content="Extended page description"><meta property="twitter:site" content="@twitterUser">');
        $this->assertEquals($openGraph, '<meta property="og:type" content="website"><meta property="og:title" content="Page title"><meta property="og:image" content="http://mypage.com/image.png"><meta property="og:url" content="http://mypage.com"><meta property="og:description" content="Extended page description">');
        $this->assertEquals($html, '<meta property="title" content="Page title"><meta property="description" content="Extended page description"><link rel="image_src" href="http://mypage.com/image.png"><link rel="canonical" href="http://mypage.com">');
    }
}
