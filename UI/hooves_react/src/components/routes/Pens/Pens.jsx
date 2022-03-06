import React from 'react'

import { useState } from 'react'

import { Link } from 'react-router-dom'

import PenList from './PenList'
import PenAdd from './PenAdd'
import PenDelete from './PenDelete'
import PenEdit from './PenEdit'

function Pens() {
  const [Nav, setNav] = useState('list')
  const [ID, setID] = useState(null)
    
  return (
      <>
        <h2>Pens</h2>
        <button onClick={() => {setNav('add')}}>Add</button>
        {Nav === 'list' && <PenList/>}
        {Nav === 'add' && <PenAdd/>}
        {Nav === 'edit' && <PenEdit/>}
      </>
  )
}

export default Pens