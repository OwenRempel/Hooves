import React from 'react'

import { Outlet } from 'react-router-dom'

function List(){
    
    return true
}
function Add(){
    
}
function Delete(){

}
function Edit(){

}

function Pens() {
    
  return (
      <>
        <h3>Pens</h3>
        <Outlet/>
      </>
  )
}

export default Pens