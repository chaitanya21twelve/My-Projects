const part1 = document.querySelector('.selection-1')
const part2 = document.querySelector('.selection-2')
const part3 = document.querySelector('.selection-3')
const part4 = document.querySelector('.selection-4')

part1.addEventListener("click", displayPart2)
part2.addEventListener("click", displayPart3)
part3.addEventListener("click", displayPart4)


const itemBox1 = part1.querySelectorAll('.item-box')
const itemBox2 = part2.querySelectorAll('.item-box')
const itemBox3 = part3.querySelectorAll('.item-box')

const itemArray1 = Array.from(itemBox1)
itemArray1.forEach(function(item){
    // console.log(item)
    item.addEventListener("click", function(){
        console.log(item)
        itemArray1.forEach(function(item){
            item.classList.remove("active")
        })
        item.classList.add("active")
    })
})
const itemArray2 = Array.from(itemBox2)
itemArray2.forEach(function(item){
    // console.log(item)
    item.addEventListener("click", function(){
        console.log(item)
        itemArray2.forEach(function(item){
            item.classList.remove("active")
        })
        item.classList.add("active")
    })
})
const itemArray3 = Array.from(itemBox3)
itemArray3.forEach(function(item){
    // console.log(item)
    item.addEventListener("click", function(){
        console.log(item)
        itemArray3.forEach(function(item){
            item.classList.remove("active")
        })
        item.classList.add("active")
    })
})



function displayPart2(){
    part2.style.display = "block"
}

function displayPart3(){
    part3.style.display = "block"
}

function displayPart4(){
    part4.style.display = "block"
}