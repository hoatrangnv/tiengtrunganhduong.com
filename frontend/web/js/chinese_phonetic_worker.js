importScripts('chinese_text_analyzer.js');

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