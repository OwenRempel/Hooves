import { Link } from "react-router-dom"

function Nav() {
    return (
        <nav className='menu'>
            <Link to='/' ><div><img src='/images/menu/Cat.png' className='menuIcon' /><span>Home</span></div></Link>
            <Link to='/list' ><div><img src='/images/menu/Cat.png' className='menuIcon' /><span>List    </span></div></Link>
            <Link to='/companies' ><div><img src='/images/menu/Cat.png' className='menuIcon' /><span>Companies   </span></div></Link>
            <Link to='/auth' ><div><img src='/images/menu/Cat.png' className='menuIcon' /><span>Auth    </span></div></Link>
        </nav>
    )
}

export default Nav
