import Link from 'next/link'
import Style from '../styles/menu.module.css'

function Nav() {
    return (
        <nav className={Style.menu}>
            <Link href='/' ><div><img src='/images/menu/Cat.png' className={Style.menuIcon} /><span>Home</span></div></Link>
            <Link href='/list' ><div><img src='/images/menu/Cat.png' className={Style.menuIcon} /><span>List    </span></div></Link>
        </nav>
    )
}

export default Nav
