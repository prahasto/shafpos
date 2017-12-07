spositems=JSON.parse(get("spositems")),
$.each(spositems,function(){
var t=this,
e=1==Settings.item_addition?t.item_id:t.id;
spositems[e]=t;
var n=t.row.id,
s=t.row.type,
r=parseFloat(t.row.tax_method),
l=t.combo_items,
i=t.row.qty,
c=parseFloat(t.row.quantity),
s=t.row.type,
d=t.row.discount,
p=t.row.code,
u=t.row.name.replace(/"/g,"&#034;").replace(/'/g,"&#039;"),
m=parseFloat(t.row.real_unit_price),
_=t.row.comment,
g=t.row.ordered?t.row.ordered:0,
f=d||"0",
v=formatDecimal(f);