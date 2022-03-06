import React from 'react'

import { useState } from 'react'

import { Link } from 'react-router-dom'

import PenList from './PenList'
import PenAdd from './PenAdd'
import PenDelete from './PenDelete'
import PenEdit from './PenEdit'

function Pens() {
  const [Nav, setNav] = useState(false)
  const [ID, setID] = useState(null)
    
  return (
      <>
        <h2>Pens</h2>
        <button className='btn' onClick={() => {setNav(!Nav)}}>{!Nav ? 'Add' : 'Close'}</button>
        {Nav && <PenAdd/>}

        <PenList/>
      </>
  )
}

export default Pens