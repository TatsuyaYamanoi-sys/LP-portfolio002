$(function() {
    const main = new Main();
});

class Main {
    constructor() {
        this._observers = [];
        this._init();
    }
    set observer(val) {
        this._observers.push(val);
    }   //setter set name.stternameに代入する時実行 _observerInit()
    get observers() {
        return this._observers;
    }   //getter 呼び出す時実行 _destroyObservers()
    _init() {
        new ClickScroll('a[href^="#"]', 400, "swing");
        setTimeout(this._zoomMainview.bind(this),100);
        setTimeout(this._observerInit.bind(this),100);
        new MobileMenu();
    }
    _zoomMainview(){
        $('.main__img,.main__inner').addClass("ready");
    }
    _textAnimation(els, inview) {
        if(inview) {
            const ta = new TweenTextAnimation(els);
            ta.animate();
        }
    }
    _observerInit() {
        this.observer = new ScrollObserver('.animate-title', this._textAnimation, {rootMargin: "-180px 0px"});
    }
    _destroyObservers() {
        this.observers.forEach(ob => {
            ob.destroy();
        });
    }

}

class ClickScroll {
    constructor(els) {
        this.DOM = $(els);
        this._init();
    }
    _init(duration, easing) {
        this.DOM.click(function(){
            const sectionHref = $(this).attr("href")
            const Posision = $(sectionHref).offset().top;
            const csOption = {duration: duration, easing: easing}
            $("html,body").animate({scrollTop : Posision}, csOption);
            console.log (Posision);
            return false;
        }); // コンポーネントclick-scroll.js
    }
}

class MobileMenu {
    constructor(els) {
        this.DOM = {};
        this.DOM.btn = $(".page-header__mobile-menu-btn");
        this.DOM.Container = $("#container");
        this.eventType = this._getEventType()
        this._init();
    }
    _init() {
        this.DOM.btn.on(this.eventType, function() {
            this.DOM.btn.toggleClass("menu-open");
            this.DOM.Container.toggleClass("menu-open");
        }.bind(this));  // thisがイベント発生源になってしまう為bindでinitのthisに束縛
    }
    _getEventType() {
        return window.ontouchstart ? 'ontouch' : 'click';
    }
}

class TextAnimation {
    constructor(els) {
        this.DOM = {};
        this.DOM.els = $(els)
        this.chars = $.trim(this.DOM.els.html()).split("");
        this.DOM.els.html(this._splitText())
    }
    _splitText() {
        return $.reduce(this.chars, function(curr) {
            curr = curr.replace(/\s+/, "&nbsp;");
            return this + '<span class ="char">' + curr + '</span>';
        },"");
    }   // returnが２つあり違和感を感じるが、reduceが結果を返し、その結果を返す為に必要。
    animate() {
        this.DOM.els.toggleClass("inview");
    }
}
class TweenTextAnimation extends TextAnimation {
    constructor(els) {
        super(els);
        this.DOM.chars = $('.char',this.DOM.els.context);   //context指定無しだとwindowをターゲットしてしまい、全charをアニメーションした。
    }
    animate() {
        this.DOM.els.addClass('inview');
        this.DOM.chars.each((i, c) => {
            TweenMax.to(c, .6, {
                ease: Back.easeOut,
                delay: i * .05,
                startAt: { y: '-50%', opacity: 0},
                y: '0%',
                opacity: 1
            });
        });
    }
}

class ScrollObserver {
    constructor(els, cb, options) {
        this.els = document.querySelectorAll(els);
        const defaultOptions = {
            root: null,
            rootMargin: "0px",
            threshold: 0,
            once: true
        };
        this.cb = cb;   // このコールバックは実際の処理
        this.options = Object.assign(defaultOptions, options);
        this.once = this.options.once;
        this._init();
    }
    _init() {
        const callback = function (entries, observer) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    this.cb(entry.target, true);
                    if(this.once) {
                        observer.unobserve(entry.target);
                    }
                } else {
                    this.cb(entry.target, false);
                }
            });
        };  // このコールバックからはスクロール検知でtrueか、trueを一度返して抜けるか、falseを返す。
            // entryにはDOM以外の要素も含まれる為unobserveはtargetでイベント発生源を指定する。

        this.io = new IntersectionObserver(callback.bind(this), this.options);
        this.io.POLL_INTERVAL = 100;
        this.els.forEach(el => this.io.observe(el));    // .observe()で引数のDOMを監視
    }
    destroy() {
        this.io.disconnect();
    }
}



// document.addEventListener('DOMContentLoaded', function () {
//     const el = document.querySelectorAll('.section-ttl');
//     const str = el.innerHTML.trim().split("");
//     el.innerHTML = str.reduce((acc, curr) => {
//         curr = curr.replace(/\s+/, '&nbsp;');
//         return `${acc}<span class="char">${curr}</span>`;
//     }, "");

//     const cb = function(el, isIntersecting) {
//         if(isIntersecting) {
//             const ta = new TweenTextAnimation(el);
//             ta.animete();
//         }
//     }
    
//     const so = new ScrollObserver('.tween-animate-title', cb);

// });

