importScripts('chinese_text_analyzer.js?v=1');

self.addEventListener('message', function (ev) {
    var args = JSON.parse(ev.data);
    var viewGroups = ChineseTextAnalyzer.phrasingParse(
        args.words,
        args.phraseMaxWords,
        args.phrasesData,
        args.wordsJoiner
    );
    postMessage(viewGroups);
}, false);