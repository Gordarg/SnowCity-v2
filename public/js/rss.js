var myPrettyCode = function() {
    hljs.configure({useBR: true});

    document.querySelectorAll('.xml').forEach((block) => {
      hljs.highlightBlock(block);
    });
};
loadStyle(Hi.baseurl() + "public/css/highlight.min.css");
loadScript(Hi.baseurl() + "public/js/highlight.min.js", myPrettyCode);