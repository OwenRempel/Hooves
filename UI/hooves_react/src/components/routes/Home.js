

function Home() {
    return (
        <div>
            <h1>Welcome {localStorage.getItem('User') && localStorage.getItem('User').split('@')[0]}</h1>
        </div>
    )
}

export default Home
