import style from '../styles/search.module.css'

function Search() {
    return (
        <div className={style.search}>
            <input type="search" className={style.searchInput} placeholder='Search'/>
        </div>
    )
}

export default Search
