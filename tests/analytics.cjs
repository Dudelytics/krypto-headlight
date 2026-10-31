const fs=require('node:fs'),vm=require('node:vm'),assert=require('node:assert/strict');
const source=fs.readFileSync(__dirname+'/../docs/assets/analytics.js','utf8');
function setup({host='headlight.dudelytics.com',dnt=false}={}) {
 let now=0,tick; const calls=[],scripts=[],events={};
 const nodes={}; for(const id of ['headlight-analytics','analytics-start','analytics-stop','analytics-status']) nodes[id]={dataset:{},addEventListener:(n,f)=>events[id+':'+n]=f};
 nodes['headlight-analytics'].dataset={websiteId:'12345678-1234-1234-1234-123456789abc',scriptUrl:'https://cloud.umami.is/script.js'};
 const window={addEventListener(){},umami:{track:p=>calls.push(p)}};
 const document={referrer:'https://example.com/private?q=secret',hidden:false,hasFocus:()=>true,getElementById:id=>nodes[id],querySelector:()=>({getBoundingClientRect:()=>({top:0,height:1000}),contains:()=>true}),createElement:()=>({dataset:{}}),head:{appendChild:s=>scripts.push(s)},addEventListener(){}};
 vm.runInNewContext(source,{document,window,location:{hostname:host,pathname:'/ausgaben/2026-10-31/',search:'?email=secret'},navigator:{doNotTrack:dnt?'1':'0'},URL,performance:{now:()=>now},innerHeight:950,Promise,setInterval:f=>tick=f});
 return {calls,scripts,nodes,document,click:id=>events[id+':click']?.(),advance:n=>{for(let i=0;i<n;i++){now+=1000;tick?.()} }};
}
let s=setup(); s.advance(10);assert.equal(s.scripts.length,0);assert.equal(s.calls.length,0);
s.click('analytics-start');assert.equal(s.scripts.length,1);assert.equal(s.scripts[0].dataset.autoTrack,'false');s.scripts[0].onload();assert.equal(s.calls.length,1);assert.equal(s.calls[0].referrer,'https://example.com');assert(!JSON.stringify(s.calls).includes('secret'));
s.advance(30);assert.equal(s.calls.filter(x=>x.name==='active_30s').length,1);s.advance(30);assert.equal(s.calls.filter(x=>x.name==='article_depth_90').length,1);
s.click('analytics-stop');let count=s.calls.length;s.advance(60);assert.equal(s.calls.length,count);
s=setup();s.click('analytics-start');s.scripts[0].onload();s.document.hidden=true;s.advance(50);assert.equal(s.calls.length,1);
s=setup({dnt:true});s.click('analytics-start');assert.equal(s.scripts.length,0);
s=setup({host:'preview.invalid'});s.click('analytics-start');assert.equal(s.scripts.length,0);
console.log('PASS: opt-in, payload minimization, one-shot thresholds, hidden tab, withdrawal, DNT, preview exclusion');
