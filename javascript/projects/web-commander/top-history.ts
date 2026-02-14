import fs from "fs";
import H from "/Users/mak13180/d/Takeout/Chrome/History.json" with {type:"json"};

const urls = H["Browser History"].map(r=>r.url);
const acc=urls.reduce((acc,url)=>{
  if(url.startsWith("https://qawebgis.esri.com"))
    url = url.replace("https://qawebgis.esri.com","https://webgis.esri.com");
  url.split("/").flatMap(r=>r.split("?")).reduce((acc,part)=>{
    if(!acc[part]) acc[part] = {__count:0};
    acc[part].__count++;
    return acc[part];
  },acc)
  return acc;
},{});
function deepSort(obj){
  return Object.fromEntries(Object.entries(obj).map(([k,v])=>[k,typeof v === "object"?deepSort(v):v]).sort((a,b)=>b[1].__count-a[1].__count))
}
const sacc=deepSort(acc["https:"][""]);

fs.writeFileSync("/Users/mak13180/d/Takeout/Chrome/HistoryTree.json", JSON.stringify(sacc,null,2));