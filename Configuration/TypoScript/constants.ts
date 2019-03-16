
plugin.tx_rtsimpleosm_sosm {
    view {
        # cat=plugin.tx_rtsimpleosm_sosm/file; type=string; label=Path to template root (FE)
        templateRootPath = EXT:rt_simpleosm/Resources/Private/Templates/
        # cat=plugin.tx_rtsimpleosm_sosm/file; type=string; label=Path to template partials (FE)
        partialRootPath = EXT:rt_simpleosm/Resources/Private/Partials/
        # cat=plugin.tx_rtsimpleosm_sosm/file; type=string; label=Path to template layouts (FE)
        layoutRootPath = EXT:rt_simpleosm/Resources/Private/Layouts/
    }
    persistence {
        # cat=plugin.tx_rtsimpleosm_sosm//a; type=string; label=Default storage PID
        storagePid =
    }
}
